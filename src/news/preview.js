const { __ } = wp.i18n
const { Spinner } = wp.components
const { Component } = wp.element
import * as axios from 'axios';

export default class PreviewNews extends Component {

	// Les états permettent de stocker les valeurs internes du composant
	state = {
		newsList: null,
	}

	componentWillMount() {

		const URL_NEWS = `https://actu-test.epfl.ch/api/v1/channels/${ this.props.channel }/news/?format=json&limit=3`;

		axios.get(URL_NEWS)
			.then( response => response.data.results )
			.then( newsList => this.setState({ newsList }) )
			.catch( err => console.log(err))
	}

	render() {

		if ( ! this.state.newsList ) {
			return (
				<p>
					<Spinner />
					{ __('Chargement des actualités') }
				</p>
			)
		}

		if ( this.state.newsList.length === 0 ) {
			return (
				<p>
					{ __('Aucune actualité trouvée') }
				</p>
			)
		} else  {
			console.log(this.state.newsList);
		}

		return (
			<div class="list-group">
			
				{ this.state.newsList.map( news => {
					return (
						<a href="#" className="list-group-item list-group-teaser link-trapeze-vertical">
							<div className="list-group-teaser-container">
						  		<div className="list-group-teaser-thumbnail">
									<picture>
										<img src={ news.thumbnail_url } className="img-fluid" alt={ news.visual_description } />
									</picture>
						  		</div>
						  		<div className="list-group-teaser-content" itemscope itemtype="http://schema.org/Article">
									<p className="h5" itemprop="name">{ news.title }</p>
									<p>
										<time datetime={ news.publish_date } itemprop="datePublished"><span class="sr-only">Published:</span>{ news.publish_date }</time>
										<span className="text-muted" itemprop="description">{ news.subtitle }</span>
									</p>
						  		</div>
							</div>
					  	</a>
						)
				}) }
			</div>
		)
	}
}
