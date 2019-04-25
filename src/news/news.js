import PreviewNews from './preview'
import InspectorControlsNews from './inspector-controls-news'

const { __ } = wp.i18n
const { Component } = wp.element
const { Fragment } = wp.element

export default class News extends Component {

    constructor(props) {
        super(props);
        let currentChannel = props.attributes.channel;
        this.state = { channel: currentChannel };
    }

    updateChannel = (newChannelID) => {
        this.setState({ channel: newChannelID });
    }

    render() {

        const { attributes, className, setAttributes } = this.props

        return (
            <Fragment>
                <InspectorControlsNews callbackNews={ this.updateChannel } { ...{ attributes, setAttributes } } />
                <PreviewNews { ...{ className } } channel={ this.state.channel } />
            </Fragment>
        )
    }

}