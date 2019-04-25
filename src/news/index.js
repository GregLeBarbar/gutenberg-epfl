import './style.scss'
import './editor.scss'

import News from './news'

const { __ } = wp.i18n
const { registerBlockType } = wp.blocks

registerBlockType(
	'greglebarbar/news',
	{
		title: __( "EPFL News"),
		description: __("Afficher la listes des news EPFL"),
		icon: 'wordpress-alt',
		category: 'common',
		keywords: [
			__( 'news' ),
		],
		attributes: {
			channel: {
				type: 'string',
				default: '1',
			}
		},
		supports : {
			customClassName: false, // Enleve le champ qui permet d'assigner une classe personnalisée
		},

		edit: props => {

			const { attributes, className, setAttributes } = props

			return (
				<News { ...{ attributes, className, setAttributes } } />
			)
		},

		save: props => {
			// On ne sauve rien en base de données car notre block est dynamique.
			// En effet, on va faire une demande à actu.epfl.ch pour retourner 
			// les N dernières news du bon canal à chaque fois que l'utilisateur 
			// va demander la page (ou plus exactement toutes les N minutes de cache)

			// Le rendu sera donc fait en php car en front-end, pour la page publiée,
			// il n'y pas de js, react, etc
			// Pour un bloc statique, PHP va rechercher en base le html de la page et le sert.
			// Mais dans le cas d'un bloc dynamique, PHP va devoir interroger actu.epfl.ch
			// et construire le html.

			// On va donc stocker quelquechose comme <!-- wp:greglebarbar/news /-->
			// Mais on devra également stocker l'id des news, le canal et les autres paramètres
			// (peut être simplement la requête à l'api REST d'actu)
			// pour que côté PHP on puisse générer le html

      return null
    },
	}
)
