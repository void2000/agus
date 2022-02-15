//enable inline edit
// CKEDITOR.dtd.$editable.span = 1;
// CKEDITOR.dtd.$editable.a = 1;
CKEDITOR.dtd.$editable.li = 1;

function StartPostEditor(id, editorname, mediapath, uploadFiles, customblocks, canvasAssets) {


  $("#savecod" + id).hide();

  window[editorname] = grapesjs.init({
   container : '#gjs' + id,
   colorPicker: { appendTo: 'parent', offset: { top: 20, left: -175 } },
   plugins: ['gjs-blocks-basic', 'gjs-plugin-ckeditor', BPEditor],   
   pluginsOpts: {      
   },
   commands: {
     defaults: [
            //window['@truenorthtechnology/grapesjs-code-editor'].codeCommandFactory(),
            window['@truenorthtechnology/grapesjs-code-editor'].codeCommandFactory({inlineCss: true}),
            ],
          },
          allowScripts: 1,
          storageManager: {
      id: 'gjs-',             // Prefix identifier that will be used inside storing and loading
      type: 'local',          // Type of the storage
      autosave: true,         // Store data automatically
      // autoload: true,         // Autoload stored data on init
      autoload: false,         // Autoload stored data on init
      stepsBeforeSave: 1,     // If autosave enabled, indicates how many changes are necessary before store method is triggered
      storeComponents: true,  // Enable/Disable storing of components in JSON format
      storeStyles: true,      // Enable/Disable storing of rules in JSON format
      storeHtml: true,        // Enable/Disable storing of components as HTML string
      storeCss: true,         // Enable/Disable storing of rules as CSS string
    },
    // canvas: {

    // },
    canvas: canvasAssets,
    baseCss: `
    * {
      box-sizing: border-box;
    }
    html, body, [data-gjs-type=wrapper] {
      min-height: 100%;
    }
    body {
      margin: 0;
      height: 100%;
      background-color: #fff
    }
    [data-gjs-type=wrapper] {
      overflow: auto;
      overflow-x: hidden;
    }
    * ::-webkit-scrollbar-track {
      background: rgba(0, 0, 0, 0.1)
    }
    * ::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.2)
    }
    * ::-webkit-scrollbar {
      width: 10px
    }
    p {
      margin-block-start: 0px;
      margin-block-end: 0px;
      margin-inline-start: 0px;
      margin-inline-end: 0px;
    }
    li p {
    margin: 0;
    }

    `,
    assetManager: {
      storageType   : '',
      storeOnChange  : true,
      storeAfterUpload  : true,
      upload: mediapath,
      assets      : [ ],
      uploadFile: function(e) {
        var files = e.dataTransfer ? e.dataTransfer.files : e.target.files;
        var formData = new FormData();
        for(var i in files){
          formData.append('file-'+i, files[i])
        }
        $.ajax({
          url: uploadFiles,
          type: 'POST',
          data: formData,
          contentType:false,
          crossDomain: true,
          dataType: 'json',
          mimeType: "multipart/form-data",
          processData:false,
          success: function(result){
            var myJSON = [];
            $.each( result['data'], function( key, value ) {
              myJSON[key] = value;
            });
            var images = myJSON;  
            window[editorname].AssetManager.add(images);
          }
        });
      },
    },
  });


  var CustomBlock = window[editorname].BlockManager;
  var Editor = window[editorname];

//set default tab
var openBl = Editor.Panels.getButton('views', 'open-blocks');
Editor.on('load', () => openBl && openBl.set('active', 1));


var  editor = Editor;


//remove builin code viewer
editor.Panels.removeButton('options', 'export-template');



const pfx = editor.getConfig('stylePrefix');
const modal = editor.Modal;
const codeViewer = editor.CodeManager.getViewer('CodeMirror').clone();
const container = document.createElement('div');
const importLabel = 'Code editor';
const importCnt = ' ';
let viewerEditor = codeViewer.editor;



//Import 
editor.Panels.addButton('options',{
  id: 'import-editor',
       className: 'fa fa-code', //I will change the icon to a better icon later if this code works
       //label: 'Save to server',
       command: {

        run(editor, sender) {
          sender && sender.set('active', false);

  // Init import button
  const btnImp = document.createElement('button');
  btnImp.type = 'button';
  btnImp.innerHTML = 'Update';
  btnImp.className = `${pfx}btn-prim ${pfx}btn-import m-2`;
  btnImp.onclick = e => {    
    editor.CssComposer.clear();
    editor.setComponents(viewerEditor.getValue().trim());
    modal.close();
  };

  // Init code viewer
  codeViewer.set({ ...{
    codeName: 'htmlmixed',
    theme: 'default',
    class: 'ty',
    readOnly: 0
  }, ...{}});


  if (!viewerEditor) {
    const txtarea = document.createElement('textarea');

        // if (importLabel) {
        //   const labelEl = document.createElement('div');
        //   labelEl.className = `${pfx}import-label`;
        //   labelEl.innerHTML = 'Paste here your HTML/CSS and click Import';
        //   container.appendChild(labelEl);
        // }

        container.appendChild(txtarea);
        container.appendChild(btnImp);
        codeViewer.init(txtarea);
        viewerEditor = codeViewer.editor;
      }

      modal.setTitle('Code editor');
      modal.setContent(container);      
      const cnt = typeof importCnt == 'function' ? importCnt(editor) : importCnt;      
      codeViewer.setContent('<style>' + editor.getCss() + '</style>' + editor.getHtml());
      modal.open().getModel()
      .once('change:open', () => editor.stopCommand(this.id));
      viewerEditor.refresh();      
      
    },

    stop() {

      modal.close();
    }


  },
  attributes: { title: 'Code editor'},
});














//Undo redo
Editor.Panels.addButton('options',{
  id: 'undo',
  className: 'fa fa-undo',  
  command: e => e.runCommand('core:undo'),
  active: false,
  attributes: { title: 'Undo'},
});

Editor.Panels.addButton('options',{
  id: 'redo',
  className: 'fa fa-repeat',  
  command: e => e.runCommand('core:redo'),
  active: false,
  attributes: { title: 'Redo'},
});


Editor.Panels.removeButton('options', 'gjs-open-import-webpage');
Editor.Panels.removeButton('options', 'canvas-clear');

Editor.Commands.add('myImportCommand', {

  run(editor, sender) {
    sender && sender.set('active', false);

    const pfx = editor.getConfig('stylePrefix');
    const modal = editor.Modal;
    const codeViewer = editor.CodeManager.getViewer('CodeMirror').clone();
    const container = document.createElement('div');
    const importLabel = 'Import HTML/CSS or Plain Text';
    const importCnt = ' ';
    let viewerEditor = codeViewer.editor;



  // Init import button
  const btnImp = document.createElement('button');
  btnImp.type = 'button';
  btnImp.innerHTML = 'Import as Code';
  btnImp.className = `${pfx}btn-prim ${pfx}btn-import`;

  const btnImpText = document.createElement('button');
  btnImpText.type = 'button';
  btnImpText.innerHTML = 'Import as Text';
  btnImpText.className = `${pfx}btn-prim ${pfx}btn-import-text`;

  btnImpText.onclick = e => {
    editor.setComponents(text2HTML(viewerEditor.getValue().trim()));   
    modal.close();
  }

  btnImp.onclick = e => {
    //editor.setComponents(viewerEditor.getValue().trim());   
    $("#pechecktext").empty();

    $("#pechecktext").append(viewerEditor.getValue().trim());

    var element = document.getElementById("pechecktext");
    var nodes=element.childNodes;
    var re = /\S/; 
    for(i=0;i<nodes.length;i++)
    { 
      if((re.test(nodes[i].nodeValue)) && (!nodes[i].tagName) )
      {            
        var span = document.createElement("p")        
        span.appendChild(document.createTextNode(nodes[i].nodeValue));
        element.replaceChild(span , nodes[i]);
      }  
    }
    window[editorname].setComponents($("#pechecktext").html() );

    modal.close();
  };

  // Init code viewer
  codeViewer.set({ ...{
    codeName: 'htmlmixed',
    theme: 'default',
    class: 'ty',
    readOnly: 0
  }, ...{}});


  if (!viewerEditor) {
    const txtarea = document.createElement('textarea');

    if (importLabel) {
      const labelEl = document.createElement('div');
      labelEl.className = `${pfx}import-label`;
      labelEl.innerHTML = 'Paste here your HTML/CSS and click Import';
      container.appendChild(labelEl);
    }

    container.appendChild(txtarea);
    container.appendChild(btnImp);
    container.appendChild(btnImpText);
    codeViewer.init(txtarea);
    viewerEditor = codeViewer.editor;
  }

  modal.setTitle('Import');
  modal.setContent(container);
  const cnt = typeof importCnt == 'function' ? importCnt(editor) : importCnt;
  codeViewer.setContent(cnt || '');
  modal.open().getModel()
  .once('change:open', () => editor.stopCommand(this.id));
  viewerEditor.refresh();
},

stop(editor, sender) {
  const modal = editor.Modal;
  modal.close();
}

});

//Import 
Editor.Panels.addButton('options',{
  id: 'import-editor',
  className: 'fa fa-download',      
  command: 'myImportCommand',
  attributes: { title: 'Import HTML/CSS or Plain Text'},
});


//Import from Word
Editor.Commands.add('myImportCommandCkeditor', {

  run(editor, sender) {
    sender && sender.set('active', false);

    const pfx = editor.getConfig('stylePrefix');
    const modal = editor.Modal;
//    const codeViewer = editor.CodeManager.getViewer('CodeMirror').clone();
const container = document.createElement('div');
const importLabel = 'Import from MS Word';
const importCnt = ' ';
  //  let viewerEditor = codeViewer.editor;


  // Init import button
  const btnImp = document.createElement('button');
  btnImp.type = 'button';
  btnImp.innerHTML = 'Import from MS Word';
  btnImp.className = `${pfx}btn-prim ${pfx}btn-import`;


  btnImp.onclick = e => {



    $("#pechecktext").empty();

    $("#pechecktext").append(CKEDITOR.instances.importword.getData());

    var element = document.getElementById("pechecktext");
    var nodes=element.childNodes;
    var re = /\S/; 
    for(i=0;i<nodes.length;i++)
    { 
      if((re.test(nodes[i].nodeValue)) && (!nodes[i].tagName) )
      {            
        var span = document.createElement("p")        
        span.appendChild(document.createTextNode(nodes[i].nodeValue));
        element.replaceChild(span , nodes[i]);
      }  
    }
    window[editorname].setComponents($("#pechecktext").html() );

    modal.close();
  };



  const txtarea = document.createElement('textarea');

  txtarea.className = `${pfx}import-area`;
  txtarea.id = 'importword';

  if (importLabel) {
    const labelEl = document.createElement('div');
    labelEl.className = `${pfx}import-label`;
    labelEl.innerHTML = 'Paste here your Doc and click Import';
     // container.appendChild(labelEl);


     container.appendChild(txtarea);
     container.appendChild(btnImp);    

   }

   modal.setTitle('Import from MS Word');
   modal.setContent(container);
   const cnt = typeof importCnt == 'function' ? importCnt(editor) : importCnt;

   modal.open().getModel()
   .once('change:open', () => editor.stopCommand(this.id));

   CKEDITOR.replace( 'importword', {height : 500});
   CKEDITOR.instances.importword.setData('Drag or Paste here your doc  -  ctrl+v');

 },

 stop(editor, sender) {
  const modal = editor.Modal;
  modal.close();
}

});

//Import 
Editor.Panels.addButton('options',{
  id: 'import-editor-ck',
  className: 'fa fa-file-word-o',      
  command: 'myImportCommandCkeditor',
  attributes: { title: 'Import from MS Word'},
});


//Clear Canvas
Editor.Panels.addButton('options',{
  id: 'trash-editor',
  className: 'fa fa-trash',
  //togglable: false,
  command: {
    run: function(editor,  sender) {

      sender && sender.set('active', false);
      if(confirm('Are you sure to clean the canvas?')){
        editor.DomComponents.clear();                                                  
      }

    },
    stop: function(editor) {

    }
  },
  active: false,
  attributes: { title: 'Clear'},
});


//Custom blocks
eval(customblocks);


//Update event
window[editorname].on('update', (some, argument) => {

 var data = '<style type="text/css">' + window[editorname].getCss() + '</style>' + window[editorname].getHtml();


 function replaceSubStr(str, subStr, replacer)
 {
  var newStr = '', n = subStr.length, N = str.length;

  for (var i = 0; i < N; i++)
    {  var j = i;
     while (j < i+n && str[j] === subStr[j-i]) j++;
     if (j === i+n)
       {  newStr += replacer;
        i += n-1;
      }
      else newStr += str[i];
    }

    return newStr;
  }
  
  data = replaceSubStr(data, ';}', ';}\n' );
  data = replaceSubStr(data, '{#', '{ #' );
  data = replaceSubStr(data, '\n\n', '' );

  var xmlData = process(data);

  document.getElementById(id).value = xmlData;

});



var text = $('#' + id).val();
text = process(text);
$('#' + id).val(text);

//wrap text
$("#pechecktext").empty();
$("#pechecktext").append($('#' + id).val());

var element = document.getElementById("pechecktext");
var nodes=element.childNodes;
var re = /\S/; 
for(i=0;i<nodes.length;i++)
{ 
  if((re.test(nodes[i].nodeValue)) && (!nodes[i].tagName) )
  {            
    var span = document.createElement("p")        
    span.appendChild(document.createTextNode(nodes[i].nodeValue));
    element.replaceChild(span , nodes[i]);
  }  
}
window[editorname].setComponents($("#pechecktext").html() );

//prevent press submit form
$(document).on('keypress', ':input:not(textarea):not([type=submit])', function (e) {
  if (e.which == 13) e.preventDefault();
});


window['mySave' + editorname] = function  () {
  window[editorname].setComponents($('#' + id).val());
  var text = $('#' + id).val();
  text = text.replace(/(?:(?:\r\n|\r|\n)\s*){2}/gm, "");
  $('#' + id).val(text);

  $("#savecod" + id).html("Ok");

  function sayHi() {
    $("#savecod" + id).html("Apply");
    var text = $('#' + id).val();
    text = text.replace(/(?:(?:\r\n|\r|\n)\s*){2}/gm, "");
    $('#' + id).val(text);

  }

  setTimeout(sayHi, 1000);

}

window['myFunction' + editorname] = function  () {
  var x = document.getElementById("cod" + id);
  var y = document.getElementById("gjs" + id);
  var z = document.getElementById("linkcod" + id);

  if (x.style.display === "block") {
    x.style.display = "none";
    y.style.display = "block";
    z.innerHTML='Builder'
    $("#savecod" + id).hide();

    $("gjs" + id).hide();
  } else {
    x.style.display = "block";
    y.style.display = "none";
    z.innerHTML='Text Editor'
    $("#savecod" + id).show();

  }
}


function process(str) {

  var div = document.createElement('div');
  div.innerHTML = str.trim();

  return format(div, 0).innerHTML;
}

function format(node, level) {

  var indentBefore = new Array(level++ + 1).join('  '),
  indentAfter  = new Array(level - 1).join('  '),
  textNode;

  for (var i = 0; i < node.children.length; i++) {

    textNode = document.createTextNode('\n' + indentBefore);
    node.insertBefore(textNode, node.children[i]);

    format(node.children[i], level);

    if (node.lastElementChild == node.children[i]) {
      textNode = document.createTextNode('\n' + indentAfter);
      node.appendChild(textNode);
    }
  }

  return node;
}



}


