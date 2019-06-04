import { registerPlugin } from "@wordpress/plugins";
import { PluginSidebar, PluginSidebarMoreMenuItem } from "@wordpress/edit-post";
import { __ } from "@wordpress/i18n";
import { PanelBody, TextControl, ColorPicker } from "@wordpress/components";
import { withSelect, withDispatch } from "@wordpress/data";

let PluginMetaFields = (props) => {
    return (
        <>
            <PanelBody
                title={__("Meta Fields Panel", "textdomain")}
                icon="admin-post"
                intialOpen={ true }
            >
                <TextControl 
                    value={props.text_metafield}
                    label={__("Text Meta", "textdomain")}
                    onChange={(value) => props.onMetaFieldChange(value)}
                />
                <ColorPicker
                    color={props.text_metafield}
                    label={__("Colour Meta", "textdomain")}
                    onChangeComplete={(colour) => props.onMetaFieldChange(colour.hex)}
                />
            </PanelBody>
        </>
    )
}

PluginMetaFields = withSelect(
    (select) => {
        return {
            text_metafield: select('core/editor').getEditedPostAttribute('meta')['_myprefix_text_metafield']
        }
    }
)(PluginMetaFields);

PluginMetaFields = withDispatch(
    (dispatch) => {
        return {
            onMetaFieldChange: (value) => {
                dispatch('core/editor').editPost({meta: {_myprefix_text_metafield: value}})
            }
        }
    }
)(PluginMetaFields);

registerPlugin( 'myprefix-sidebar', {
    icon: 'smiley',
    render: () => {
        return (
            <>
                <PluginSidebarMoreMenuItem
                    target="myprefix-sidebar"
                >
                    {__('Meta Options', 'textdomain')}
                </PluginSidebarMoreMenuItem>
                <PluginSidebar
                    name="myprefix-sidebar"
                    title={__('Meta Options', 'textdomain')}
                >
                    <PluginMetaFields />
                </PluginSidebar>
            </>
        )
    }
})