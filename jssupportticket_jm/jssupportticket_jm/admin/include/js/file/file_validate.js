function uploadfileNote(fileobj,filesizeallow,fileextensionallow) {
    var file = fileobj.files[0];
    var name = file.name;
    var size = (file.size)/1024; //kb
    var type = file.type;
    var fileext =getExtension(name);
    replace_txt="<input type='file' class='inputbox' name='noteattachment' onchange='uploadfileNote(this,"+'"'+filesizeallow+'"'+","+'"'+fileextensionallow+'"'+");' size='20' maxlenght='30'/>";
    if(size > filesizeallow ){
            jQuery(fileobj).replaceWith(replace_txt);				
            alert(Joomla.JText._('Error file size too large'));
            return false;
    }
    var f_e_a=fileextensionallow.split(','); // file extension allow array
    var isfileextensionallow=checkExtension(f_e_a,fileext);
    if(isfileextensionallow == 'N'){
            jQuery(fileobj).replaceWith(replace_txt);				
            alert(Joomla.JText._('Error file extension mismatch'));                    
            return false;
    }
    return true;
}
function uploadfile(fileobj,filesizeallow,fileextensionallow) {
    var file = fileobj.files[0];
    var name = file.name;
    var size = (file.size)/1024; //kb
    var type = file.type;
    var fileext =getExtension(name);
    replace_txt="<input type='file' class='inputbox' name='filename[]' onchange='uploadfile(this,"+'"'+filesizeallow+'"'+","+'"'+fileextensionallow+'"'+");' size='20' maxlenght='30'/><span  class='tk_attachment_remove'></span>";
    if(size > filesizeallow ){
            jQuery(fileobj).replaceWith(replace_txt);				
            alert(Joomla.JText._('Error file size too large'));
            return false;
    }
    var f_e_a=fileextensionallow.split(','); // file extension allow array
    var isfileextensionallow=checkExtension(f_e_a,fileext);
    if(isfileextensionallow == 'N'){
            jQuery(fileobj).replaceWith(replace_txt);				
            alert(Joomla.JText._('Error file extension mismatch'));                    
            return false;
    }
    return true;
}
function  checkExtension(f_e_a,fileext) {
    var match = 'N';
    for(var i=0 ;i<f_e_a.length;i++){
            if(f_e_a[i].toLowerCase() === fileext){
                    match = 'Y';
                    break;
            }
    }
    return match;
}
function getExtension(filename) {
    return filename.split('.').pop().toLowerCase();
}
