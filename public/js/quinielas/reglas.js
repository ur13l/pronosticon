$(function() {
    ClassicEditor
    .create( document.querySelector( '#reglas' ), {
        toolbar: [ 'headings', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
        height:"800px"
    }  )
    .catch( error => {
        console.error( error );
    } );
});