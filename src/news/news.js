const { Fragment } = wp.element

export default class News extends Component {

    render() {
        return (
            <Fragment>
                <InspectorControlsNews { ...{ attributes, setAttributes } } />
                <PreviewNews { ...{ attributes, className } } />
            </Fragment>
        )
    }
}