$('#sortable').sortable();
$('#sortable').disableSelection();
    
$('#sortable').bind('sortstop', function (e, ui) {
    // ソートが完了したら実行される。
    var rowy = $('#sortable .sort');
    for (var u = 0, rowTotal = rowy.length; u < rowTotal; u += 1) {
        $($('.sort')[u]).val(u + 1);
    }
})