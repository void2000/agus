function BPEditor(editor, options){

var blockManager = editor.BlockManager;
blockManager.add('table-block', {
  id: 'table',
  label: 'Table',
  category: 'Basic',
  attributes: { class: 'fa fa-table' },
  content: `<style>td { min-width: 100px; height: 20px;}</style>
  <table class="table  table-bordered table-resizable">
  <tr><td></td><td></td><td></td></tr>
  <tr><td></td><td></td><td></td></tr>
  <tr><td></td><td></td><td></td></tr>
  </table>
  `,
});
var TOOLBAR_CELL = [
{
  attributes: { class: "fa fa-arrows" },
  command: "tlb-move"
},
{
  attributes: { class: "fa fa-flag" },
  command: "table-insert-row-above"
},

{
  attributes: {class: 'fa fa-clone'},
  command: 'tlb-clone',
},
{
  attributes: {class: 'fa fa-trash-o'},
  command: 'tlb-delete',
}
];
var getCellToolbar = () => TOOLBAR_CELL;


var components = editor.DomComponents;
var text = components.getType('text');
components.addType('cell', {
  model: text.model.extend({
    defaults: Object.assign({}, text.model.prototype.defaults, {
      type: 'cell',
      tagName: 'td',
      draggable: ['tr'],
      
    }),
  },

  {
    isComponent(el) {
      let result;
      var tag = el.tagName;
      if (tag == 'TD' || tag == 'TH') {
        result = {
          type: 'cell',
          tagName: tag.toLowerCase()
        };
      }
      return result;
    }
  }),
  view: text.view,
});



editor.on('component:selected', m => {
  var compType = m.get('type');
  switch (compType) {
    case 'cell':
                  m.set('toolbar', getCellToolbar()); // set a toolbars
                }
              });



editor.Commands.add('table-insert-row-above', editor => {
  var selected = editor.getSelected();

  if (selected.is('cell')) {
    var rowComponent = selected.parent();
    var rowIndex = rowComponent.collection.indexOf(rowComponent);
    var cells = rowComponent.components().length;
    var rowContainer = rowComponent.parent();

    rowContainer.components().add({
      type: 'row',
      components: [...Array(cells).keys()].map(i => ({
        type: 'cell',
        content: 'New Cell',
      }))
    }, { at: rowIndex });
  }
});


// list
editor.BlockManager.add('ul-block-box', {
  label: 'Unordered List',
  content: `<ul>
    <li>item</li>
    <li>item</li>
    <li>item</li>
  </ul>`,
  category: 'Basic',
  attributes: { class: 'fa fa-list-ul' },
});



//numbered list
editor.BlockManager.add('ol-block-box', {
  label: 'Numbered list',
  content: `<ol>
    <li>item</li>
    <li>item</li>
    <li>item</li>
  </ol>`,
  category: 'Basic',
  attributes: { class: 'fa fa-list-ol' },
});



}