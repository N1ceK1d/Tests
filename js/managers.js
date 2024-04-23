function fill_managers(managers_list, id) {
    $.map(managers_list, (item) => {
        console.log(item);
        $('#select'+id).append(`<option value='${JSON.stringify(item)}'>ho</oprion>`);
    })
}