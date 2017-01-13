(function() {
  tinymce.PluginManager.add('aj_tc_button', function( editor, url ) {
    editor.addButton( 'aj_tc_button', {
      title: 'Shortcodes',
      text: 'Shortcodes',
      type: 'menubutton',
      icon: 'icon-bow',
      menu:
      [
      {
        text: 'Text with Icon',
        value: 'Text with Icon',
        onclick: function() {
          editor.windowManager.open( {
            title: 'Add Text with Icon',
            body: [
            { type: 'textbox', multiline: true, name: 'content', label: 'Text', minWidth: 300 },
            { type: 'textbox', name: 'text1', label: 'Block Title' },
            { type: 'textbox', name: 'text2', label: 'Block Text' },
            {
              type   : 'listbox',
              name   : 'icon',
              label  : 'Icon',
              values : [
              { text: 'Quote', value: 'quote' },
              { text: 'Music', value: 'music' },
              { text: 'Tip', value: 'tip' },
              { text: 'Don’t forget / Keep in Mind', value: 'dont-forget' },
              { text: 'Bride’s Advice', value: 'brides-advice' },
              { text: 'Fun Fact', value: 'fun-fact' }
              ],
              value : 'quote' // Sets the default
            },
            {
              type   : 'listbox',
              name   : 'color',
              label  : 'Icon color',
              values : [
              { text: 'Brand color', value: 'brand' },
              { text: 'Blue', value: 'blue' }
              ],
              value : 'brand' // Sets the default
            },
            { type: 'textbox', name: 'url', label: 'Image Url' },
            {
              type   : 'listbox',
              name   : 'position',
              label  : 'Image Position',
              values : [
              { text: 'Left', value: 'left' },
              { text: 'Right', value: 'right' }
              ],
              value : 'left' // Sets the default
            }
            ],
            onsubmit: function( e ) {
              editor.insertContent( '[text-with-icon icon="'+e.data.icon+'" color="'+e.data.color+'" text="'+e.data.content+'" block-title="'+e.data.text1+'" block-text="'+e.data.text2+'" image-url="'+e.data.url+'" image-position="'+e.data.position+'" ]');
            }
          });
        }
      }
      ]
    });
  });
})();
