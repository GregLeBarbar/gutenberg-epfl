import * as axios from 'axios';

const { __ } = wp.i18n
const { Component } = wp.element

const {
	InspectorControls,
} = wp.editor

const {
	PanelBody,
	SelectControl
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
            
            // console.log(this.state.channelsList);

            let optionsList = [];
            this.state.channelsList.forEach(channel => {
                optionsList.push({ label: channel.name, value: channel.id });
            });

            // console.log(optionsList);
    
            content = (
                <InspectorControls>
                    <PanelBody title={ __( 'Configuration' ) }>
                        <SelectControl 
                        label="Channel"
                        value={ attributes.channel }
                        options={ optionsList }
                        onChange={ channel => setAttributes( { channel } ) }
                        />
                    </PanelBody>
                </InspectorControls>
            )
        }

        return content;
    }
}