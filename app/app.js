const API_URL = '/api/';

const todo_list = document.querySelector('.todo_list');
const todo_add_btn = document.getElementById('todo_add_btn');
const todo_input = document.querySelector('#todo_input');

const TEXT_MAX_LENGTH = 50;
const TEXT_MIN_LENGTH = 1;

window.onload = e => {

    // get all tasks already added
    sendRequest('GET', API_URL + 'read.php', null)
        .then(data => {
            data.forEach(item => {
                makeTodo(item, 'end')
            });
        })
        .catch(err => console.error(err))

    // adding event listener to add btn
    todo_add_btn.addEventListener('click', () => {
        let text = todo_input.value;

        //check if text is not longer than N
        if(text.length > TEXT_MAX_LENGTH)
        {
            alert("Task is too long, shorten it, please!");
        }
        else if(text.length < TEXT_MIN_LENGTH)
        {
            alert("Task is too short, make it longer, please!");
        }
        else
        {
            //add to database
            let url = API_URL + 'add.php';
            let body = {
                text: text
            }

            sendRequest('POST', url, body)
                .then(data => {
                    if(data.ok == true)
                    {
                        makeTodo(body, 'end');
                        todo_input.value = '';
                    }
                    else
                    {
                        alert(data.message);
                    }
                })
                .catch(err => console.error(err))
        }

    });
}

function sendRequest(method, url, body = null)
{
    const headers = {
        'Content-Type' : 'application/json'
    }
    return fetch(url, {
        method: method,
        body: body ? JSON.stringify(body) : null,
        headers: headers
    }).then(response => {
        if(response.ok){
            return response.json()
        }

        return response.json().then(error => {
            const e = new Error('Smth went wrong')
            e.data = error
            throw e;
        })
    })
}

function makeTodo( obj, appendWhere = 'begin' )
{
    //creating new elements
    let new_todo = document.createElement('div');
    let new_todo_input = document.createElement('input');
    let new_todo_buttons_box = document.createElement('div');
    let new_todo_complete_btn = document.createElement('button');

    //adding classes
    new_todo.classList.add('todo');
    new_todo_complete_btn.classList.add('complete_btn');
    new_todo_buttons_box.classList.add('todo_buttons');

    //appending
    new_todo.appendChild(new_todo_input);
    new_todo.appendChild(new_todo_buttons_box);

    new_todo_buttons_box.appendChild(new_todo_complete_btn);

    //adding values and attributes
    new_todo_input.value = obj.text;
    new_todo_input.readOnly = true;
    new_todo_complete_btn.innerText = "Complete";

    //adding event listeners
    new_todo_complete_btn.addEventListener('click', () => {
        new_todo_complete_btn.disabled = true;
        let text = new_todo_input.value;
        
        let url = API_URL + 'delete.php';

        sendRequest('POST', url, {text: text})
            .then(data => {
                if(data.ok === true)
                {
                    todo_list.removeChild(new_todo);
                }
                else
                {
                    alert(data.message);
                    new_todo_complete_btn.disabled = false;
                }
            })
            .catch(err => {
                console.error(err);
                new_todo_complete_btn.disabled = false;
            })
    });

    //appending
    if(appendWhere === 'end')
    {
        todo_list.appendChild(new_todo);
    }
    else if(appendWhere === 'begin')
    {
        todo_list.prepend(new_todo);
    }

};