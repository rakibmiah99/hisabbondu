function LoadingButton(selectBtn){
    selectBtn.addClass("d-none");
    selectBtn.next().removeClass('d-none');
}

function RemoveLoadingButton(selectBtn){
    selectBtn.removeClass("d-none");
    selectBtn.next().addClass("d-none");
}

function LoadingModal(selector){
    selector.removeClass("d-none");
    selector.next().addClass('d-none');
}
function RemoveLoadingModal(selector){
    selector.addClass("d-none");
    selector.next().removeClass("d-none");
}


// Function Error Toast Message
function ErrorToast(msg) {
    toastr.options.positionClass = 'toast-bottom-center';
    toastr.error(msg);
}

// Function Success Toast Messsage
function SuccessToast(msg) {
    toastr.options.positionClass = 'toast-bottom-center';
    toastr.success(msg);
}

function editor(editorSelector){
    editorSelector.summernote({
        placeholder: '',
        tabsize: 2,
        height: 350,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['height', ['height']]
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ]
    });
}
