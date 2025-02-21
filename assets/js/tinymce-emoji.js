(function() {
    tinymce.create('tinymce.plugins.BoxmoeEmoji', {
        init: function(editor, url) {
            editor.addButton('boxmoe_emoji', {
                type: 'menubutton',
                text: '表情',
                icon: false,
                menu: (function() {
                    var emojiList = editor.settings.boxmoe_emoji_list;
                    var items = [];
                    
                    for (var emoji in emojiList) {
                        items.push({
                            text: emoji + ' ' + emojiList[emoji],
                            onclick: (function(e) {
                                return function() {
                                    editor.insertContent(' ' + e + ' ');
                                };
                            })(emoji)
                        });
                    }
                    
                    return items;
                })()
            });
        },
        createControl: function(n, cm) {
            return null;
        },
    });
    
    tinymce.PluginManager.add('boxmoe_emoji', tinymce.plugins.BoxmoeEmoji);
})();