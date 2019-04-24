import './style.scss'
import './editor.scss'

import PreviewNews from './preview'

const { __ } = wp.i18n
const { registerBlockType } = wp.blocks

const {

	InspectorControls,

} = wp.editor

const {
	PanelBody,
	SelectControl
} = wp.components

const { Fragment } = wp.element

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

		edit: props => {
			const { className } = props

			return (
				<Fragment>
					<InspectorControls>
						<PanelBody title={ __( 'Je ne sais pas' ) }>
							<SelectControl 
							label="Channel"
							value={ props.attributes.channel }
							options={ [
									{ label: 'Mediacom', value: '1' },
									{ label: 'ENAC', value: '6' },
									{ label: 'STI', value: '10' },
							] }
							onChange={ channel => props.setAttributes( { channel } ) }
							/>
						</PanelBody>
					</InspectorControls>
					<PreviewNews { ...{ className } } />
				</Fragment>
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
