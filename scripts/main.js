$(function(){
    var rows = $("#tbl").children('tbody').children('tr');
    console.log(rows);
    function show(state) {

        document.getElementById('window').style.display = state;
        document.getElementById('wrap').style.display = state;
    }
})