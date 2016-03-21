window.addEventListener('load', function() {
    var editor;

    /*ContentTools.StylePalette.add([
        new ContentTools.Style('Author', 'author', ['p'])
    ]);*/
    
    editor = ContentTools.EditorApp.get();
    editor.init('*[data-editable]', 'data-name');


    editor.bind('save', function (regions) {
    var name, payload, xhr;

    // Set the editor as busy while we save our changes
    this.busy(true);

    $.ajax({
        url : urlSlug,
        method : 'POST',
        data : {content:regions['content']},
        success : function(){editor.busy(false); new ContentTools.FlashUI('ok');},
        error : function(){editor.busy(false); new ContentTools.FlashUI('no');}
        
    });


    // Collect the contents of each region into a FormData instance
    /*payload = new FormData();
    for (name in regions) {
        if (regions.hasOwnProperty(name)) {
            payload.append(name, regions[name]);
        }
    }*/

    // Send the update content to the server to be saved
    /*function onStateChange(ev) {
        // Check if the request is finished
        if (ev.target.readyState == 4) {
            editor.busy(false);
            if (ev.target.status == '204') {
                // Save was successful, notify the user with a flash
                new ContentTools.FlashUI('ok');
            } else {
                // Save failed, notify the user with a flash
                new ContentTools.FlashUI('no');
            }
        }
    };

    xhr = new XMLHttpRequest();
    xhr.addEventListener('readystatechange', onStateChange);
    xhr.open('POST', urlSlug);
    xhr.send(payload);*/
});

});