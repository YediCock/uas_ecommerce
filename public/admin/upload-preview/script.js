
function previewMulti(target, images) {
    $(target).empty(); // Clear previous previews
    for (let i = 0; i < images.length; i++) {
        const img = document.createElement('img');
        img.src = window.URL.createObjectURL(images[i]);
        img.classList.add('img-preview', 'img-fluid', 'mb-3', 'col-sm-6', 'col-md-4', 'd-block');
        img.style.maxWidth = '160px'; 
        $(target).append(img);
    }
}


// upload tunggal
function previewSketsa(target, image){
    $(target)
    .attr('src', window.URL.createObjectURL(image))
    .css('max-width', '160px') 
    .show();
}
function previewDenah(target, image){
    $(target)
    .attr('src', window.URL.createObjectURL(image))
    .css('max-width', '160px') 
    .show();
}