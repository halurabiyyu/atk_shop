<?php
function antiinjection($conn, $data){
    // Hapus karakter khusus dan hindari SQL injection
    $filteredData = sqlsrv_query($conn, "DECLARE @data NVARCHAR(MAX); SET @data = ?", array($data));

    if ($filteredData === false) {
        // Handle the error if query fails
        die(print_r(sqlsrv_errors(), true));
    }

    // Fetch the results
    $row = sqlsrv_fetch_array($filteredData, SQLSRV_FETCH_ASSOC);

    // Return the filtered data
    return $row['data'];
}
?>