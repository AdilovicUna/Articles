let curr_page = 1;
let len = table.rows.length;
let limit = 10;
let num_of_pages = Math.ceil(len / limit);

function split_table() {
    let table = document.getElementById("table");
    let elem = 0;

    for (let i = 1; i <= num_of_pages; i++) {
        for (let j = 1; j <= 10; j++) {
            if (i == num_of_pages && len % limit != 0 && j > len % limit) {
                break;
            }
            table.rows[elem].className = "page_" + i;
            elem++;
        }
    }

    show_curr_page();
}

function show_curr_page()
{
    for (let i = 1; i <= num_of_pages; i++) {
        let page = document.getElementsByClassName("page_" + i);
        if (curr_page == i) {
            for (let j = 0; j < page.length; j++) {
                page[j].style.display = "table-row";
            }
        }
        else {
            for (let j = 0; j < page.length; j++) {
                page[j].style.display = "none";
            }  
        }
    }
}

function show_curr_page_num() {
    let page = document.getElementById("page");
    page.innerHTML = "Page count " + curr_page;
}

function nextHandler() {
    if(curr_page > 0 && curr_page < num_of_pages)
    {
        curr_page += 1;
        show_curr_page();
    }
    show_buttons();
    show_curr_page_num();
}

function prevHandler() {
    if(curr_page > 1 && curr_page <= num_of_pages)
    {
        curr_page -= 1;
        show_curr_page();
    }
    show_buttons();
    show_curr_page_num();
}

function newArticleHandler(hide_create){
    let newArticle = document.getElementById("newArticle");
    newArticle.hidden = hide_create;

    let showArticles = document.getElementById("showArticles");
    showArticles.hidden = !hide_create;
}

function show_buttons(){
    if(curr_page == num_of_pages)
    {
        next.hidden = true;
        prev.hidden = false;
    }
    else if(curr_page == 1)
    {
        next.hidden = false;
        prev.hidden = true;
    }
    else
    {
        next.hidden = false;
        prev.hidden = false;
    }
}

let next = document.getElementById("next");
next.addEventListener('click', event => nextHandler());

let prev = document.getElementById("previous");
prev.addEventListener('click', event => prevHandler());

let createArticle = document.getElementById("createArticle");
createArticle.addEventListener('click', event => newArticleHandler(false));

let cancel = document.getElementById("back");
cancel.addEventListener('click', event => newArticleHandler(true));

split_table();
show_curr_page_num();
show_buttons();


