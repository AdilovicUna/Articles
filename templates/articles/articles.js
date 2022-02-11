let original = document.getElementById("table");
//original.hidden = false;
//let clone =  original.cloneNode(true);

let curr_page = 1;
let limit = 10;
let num_of_pages = Math.ceil(original.rows.length / limit);


function show_curr_page(my_table = "") {
    if (my_table == "") {
        my_table = document.getElementById("table");
    }
    
    let len = my_table.rows.length;
    let elem = 0;
    let prev_num_of_pages = num_of_pages;
    num_of_pages = Math.ceil(len / limit);
    if(prev_num_of_pages != num_of_pages)
    {
        curr_page--;
    }

    for (let i = 1; i <= num_of_pages; i++) {
        for (let j = 1; j <= 10; j++) {
            if (i == num_of_pages && len % limit != 0 && j > len % limit) {
                break;
            }
            if(i == curr_page)
            {
                my_table.rows[elem].hidden = false;
            }
            else{
                my_table.rows[elem].hidden = true;

            }
            elem++;
        }
    }
}

function rebuild_table(my_table) {
    let old_table = document.getElementById("table");
    while (old_table.rows.length > 0) {
        old_table.deleteRow(0);
    }
    let elem = 0
    for (const [key, value] of Object.entries(my_table)) {
        var row = old_table.insertRow(elem);
        elem++;

        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell5 = row.insertCell(4);

        cell1.innerHTML = value['name'];
        cell1.id = "name";
        cell2.innerHTML = value['tag'];
        cell2.className = "tag";
        cell3.innerHTML = '<a id="show" href="/~31140072/cms/article/' + value['id'] + '">Show</a>';
        cell4.innerHTML = '<a id="edit" href="/~31140072/cms/article-edit/' + value['id'] + '">Edit</a>';
        cell5.innerHTML = '<a class="delete" id=' + value['id'] + '>Delete</a>';

    }
    show_curr_page();
    show_buttons();
    show_curr_page_num();
}

function filter_table(tag) {    
    let clone = original.cloneNode(true);
    if(document.getElementById('articlesTable').children.length > 1)
    {
        document.getElementById('articlesTable').lastChild.remove();
    }
    document.getElementById('articlesTable').appendChild(clone);
    original.hidden = true;
    clone.hidden = false;

    let rows_for_deletion = []
    for (let i = 0; i < clone.rows.length; i++) {
        if (clone.rows[i].cells[1].innerHTML != tag) {
            rows_for_deletion.push(i);
        }

    }
    rows_for_deletion.sort(function (a, b) {
        return a - b;
    });
    rows_for_deletion.reverse();
    for (let r = 0; r < rows_for_deletion.length; r++) {
        clone.deleteRow(rows_for_deletion[r]);
    }
    curr_page = 1;
    show_curr_page(clone);
    show_buttons();
    show_curr_page_num();
}

function show_curr_page_num() {
    let page = document.getElementById("page");
    page.innerHTML = "Page count " + num_of_pages;
}

function nextHandler() {
    if (curr_page > 0 && curr_page < num_of_pages) {
        curr_page += 1;
        show_curr_page();
    }
    show_buttons();
    show_curr_page_num();
}

function prevHandler() {
    if (curr_page > 1 && curr_page <= num_of_pages) {
        curr_page -= 1;
        show_curr_page();
    }
    show_buttons();
    show_curr_page_num();
}

function newArticleHandler(hide_create) {
    let newArticle = document.getElementById("newArticle");
    newArticle.hidden = hide_create;

    let showArticles = document.getElementById("showArticles");
    showArticles.hidden = !hide_create;
}

async function deleteHandler(event,id) {
    try {
        const result = await fetch("./delete/" + id,
            {
                method: "DELETE",
            });
        event.target.parentElement.parentElement.remove();
        show_curr_page();
        show_curr_page_num();
        show_buttons();
        return true;
    } catch (err) {
        return err;
    }

}

function filterHandler() {
    let listObj = document.getElementById("all_tags");
    let datalist = document.getElementById(listObj.getAttribute("list"));
    let element = datalist.options.namedItem(listObj.value);
    let tag = element.id;
    filter_table(tag);
}

function show_buttons() {
    if (num_of_pages == 1) {
        next.hidden = true;
        prev.hidden = true;
    }
    else if (curr_page == num_of_pages) {
        next.hidden = true;
        prev.hidden = false;
    }
    else if (curr_page == 1) {
        next.hidden = false;
        prev.hidden = true;
    }
    else {
        next.hidden = false;
        prev.hidden = false;
    }
}

let delete_button = document.getElementsByClassName("delete");
for (let index = 0; index < delete_button.length; index++) {
    const element = delete_button[index];
    element.addEventListener('click', event =>
        deleteHandler(event,element.id).then(data => console.log(data))
    );
}

let next = document.getElementById("next");
next.addEventListener('click', event => nextHandler());

let prev = document.getElementById("previous");
prev.addEventListener('click', event => prevHandler());

let createArticle = document.getElementById("createArticle");
createArticle.addEventListener('click', event => newArticleHandler(false));

let cancel = document.getElementById("back");
cancel.addEventListener('click', event => newArticleHandler(true));

show_curr_page();
show_curr_page_num();
show_buttons();


