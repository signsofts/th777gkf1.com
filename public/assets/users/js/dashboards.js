try {
    const showModaMapLine = document.getElementById('showModaMapLine');
    var bootstrapShowModaMapLine = new bootstrap.Modal(showModaMapLine);
    bootstrapShowModaMapLine.toggle();
} catch (error) {
    console.log(error)
}