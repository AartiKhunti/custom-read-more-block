var el = wp.element.createElement,
    registerBlockType = wp.blocks.registerBlockType,
    TextControl = wp.components.TextControl,
    PanelBody = wp.components.PanelBody,
    Button = wp.components.Button;

registerBlockType('custom-read-more-block/read-more-block', {
    title: 'Read More Block',
    icon: 'admin-plugins',
    category: 'common',
    attributes: {
        selectedPost: {
            type: 'object',
            default: null,
        },
    },

    edit: function (props) {
        const { selectedPost } = props.attributes;
        const { apiFetch } = wp;

        const onSearchPosts = (searchString) => {

            // Fetch posts based on the search string using the REST API
            apiFetch({ path:`/wp/v2/posts?per_page=5&search=${searchString}`})
                .then((data) => {
                    props.setAttributes({ selectedPost: data[0] });
            });
        };

        const onClearSelection = () => {
            props.setAttributes({ selectedPost: null });
        };

        const inspectorControls = el(
            PanelBody,
            { title: 'Search a Post' },
            el(TextControl, {
                placeholder: 'Search for a post...',
                onChange: onSearchPosts,
            })
        );

        const selectedPostContent = selectedPost && el(
            'div',
            {},
            el('p', { className: 'selected-post' }, 'Selected Post: ' + selectedPost.title.rendered),
            el(
                Button,
                { isDestructive: true, onClick: onClearSelection },
                'Clear Selection'
            )
        );

        return el(
            'div',
            { className: 'main-block-div' },
            inspectorControls,
            selectedPostContent
        );
    },

    save: function (props) {
        
        const { selectedPost } = props.attributes;

        if (!selectedPost) {
            return null;
        }

        const anchorText = selectedPost.title.rendered;
        const anchorHref = selectedPost.link;

        return el(
            'p',
            { className: 'dmg-read-more' },
            'Read More: ',
            el('a', { href: anchorHref }, anchorText)
        );
    },
});
