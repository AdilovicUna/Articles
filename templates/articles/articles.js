let curr_page = 1;
let len = table.rows.length;
let limit = 10;
let num_of_pages = Math.floor(len / limit);

if (len % limit != 0) {
    num_of_pages += 1;
}

function split_table() {
    let table = document.getElementById("table");
    let temp_curr_page = 1
    let elem = 0;

    for (let i = 1; i <= num_of_pages; i++) {
        for (let j = 0; j < limit; j++) {
            if (temp_curr_page == num_of_pages && j >( len % limit) - 1) {
                break;
            }
            table.rows[elem].className = "page_" + i;
            elem++;
        }
        temp_curr_page++;
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

function show_buttons(){
    if(curr_page == num_of_pages)
    {
        next.style.visibility = "hidden";
        prev.style.visibility = "visible";
    }
    else if(curr_page == 1)
    {
        next.style.visibility = "visible";
        prev.style.visibility = "hidden";
    }
    else
    {
        next.style.visibility = "visible";
        prev.style.visibility = "visible";
    }
}

let next = document.getElementById("next");
next.addEventListener('click', event => nextHandler());

let prev = document.getElementById("previous");
prev.addEventListener('click', event => prevHandler());

split_table();
show_curr_page_num();
show_buttons();


