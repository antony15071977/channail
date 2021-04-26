CKEDITOR.plugins.add('agpb',{
  init: function(editor){
    var cmd = editor.addCommand('agpb', {
      exec:function(editor){
        editor.insertHtml('<div class="agpb">&nbsp;</div><!-- pagebreak -->'); // работа плагина
      }
    });
    cmd.modes = { wysiwyg : 1, source: 1 };// плагин будет работать и в режиме wysiwyg и в режиме исходного текста
    editor.ui.addButton('agpb',{
      label: '',
	  title: 'Разрыв страницы',
      command: 'agpb',
      toolbar: 'about'
    });
  },
  icons:'agpb', // иконка
});