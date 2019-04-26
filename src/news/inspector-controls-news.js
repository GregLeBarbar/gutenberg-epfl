import * as axios from 'axios';

const { __ } = wp.i18n
const { Component } = wp.element

const {
	InspectorControls,
} = wp.editor

const {
	PanelBody,
    SelectControl,
    RadioControl,
    ToggleControl,
} = wp.components

export default class InspectorControlsNews extends Component {

    constructor(props) {
        super(props);
        this.state = { channelsList : null }
    }

    componentWillMount() {
		axios.get('https://actu-test.epfl.ch/api/v1/channels/?format=json&limit=800')
			.then( response => response.data.results )
			.then( channelsList => this.setState({ channelsList }) )
            .catch( err => console.log(err))
	}

    render() {

        const { attributes, setAttributes } = this.props
        
        let content = "";
        
        if (this.state.channelsList !== null) {
            
            let optionsChannelsList = [];

            this.state.channelsList.forEach(channel => {
                optionsChannelsList.push({ label: channel.name, value: channel.id });
            });

            let optionsTemplatesList = [
                { value: '1', label: __('Template Listing')},
                { value: '2', label: __('Template highlighted with 3 news')},
                { value: '3', label: __('Template highlighted with 1 news')},
                { value: '4', label: __('Template card with 1 news')},
                { value: '5', label: __('Template card with 2 news')},
                { value: '6', label: __('Template card with 3 news')},
            ];

            let optionsLanguagesList = [
                { value: 'fr', label: __('French') },
                { value: 'en', label: __('English') },
            ]

            let optionsCategoriesList = [
                { value: '0', label: __('No filter') },
                { value: '1', label: __('Epfl') },
                { value: '2', label: __('Education') },
                { value: '3', label: __('Research') },
                { value: '4', label: __('Innovation') },
                { value: '5', label: __('Campus Life') },
            ]

            content = (
                <InspectorControls>
                    <PanelBody title={ __( 'Configuration' ) }>
                        <SelectControl 
                            label={ __("Select your news channel") }
                            help={ __("The news come from the application actu.epfl.ch. If you don't have a news channel, please send a request to 1234@epfl.ch") }
                            value={ attributes.channel }
                            options={ optionsChannelsList }
                            onChange={ channel => setAttributes( { channel } ) }
                        />
                        <RadioControl
                            label={ __("Select a template") }
                            help={ __("Do you need more information about templates? Read this documentation") }
                            selected={ attributes.template }
                            options={ optionsTemplatesList }
                            onChange={ template => setAttributes( { template } ) }
	                    />
                        <ToggleControl
                            label={ __('Display the link "all news"') }
                            checked={ attributes.displayLinkAllNews }
                            onChange={ () => setAttributes( { displayLinkAllNews: ! attributes.displayLinkAllNews } ) }
                        />
                        <RadioControl
                            label={ __("Select a language") }
                            help={ __("The language used to render news results") }
                            selected={ attributes.lang }
                            options={ optionsLanguagesList }
                            onChange={ lang => setAttributes( { lang } ) }
	                    />
                        <RadioControl
                            label={ __("Filter news by category") }
                            help={ __("Do you want filter news by category? Please select a category") }
                            selected={ attributes.category }
                            options={ optionsCategoriesList }
                            onChange={ category => setAttributes( { category } ) }
	                    />
                    </PanelBody>
                </InspectorControls>
            )
        }
        return content;
    }
}