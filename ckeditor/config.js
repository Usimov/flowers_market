/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

$(function(){
$( '.ckeditor' ).ckeditor({
				uiColor: '#eef4ff',
				toolbar: [
					[ 'Source','Undo','Redo','Cut','Copy','Paste','PasteText','PasteFromWord','Templates' ],
					[ 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','NumberedList','BulletedList','-','Outdent','Indent' ],
					[ 'Bold','Italic','Underline','Strike','Subscript','Superscript' ],
					[ 'Find','Replace','SelectAll','SpellChecker' ],
					[ 'Link','Unlink','Anchor' ],
					[ 'Image','Flash','Table','HorizontalRule','SpecialChar','PageBreak','Iframe' ],
					[ 'Styles','Format','Font','FontSize' ],
					[ 'TextColor','BGColor' ],
					[ 'Maximize', 'ShowBlocks' ]
				]
			});
});