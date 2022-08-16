<!DOCTYPE html>
<html>
    <head>
        <title>Calender</title>
        <link href='https://fonts.googleapis.com/css?family=Montserrat:700,400' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
        <link rel="stylesheet" href="./index.css">
        <link rel="stylesheet" href="./style.css">
    </head>
    




    <body>
        <p>
        <?php
            session_start();
            $username = $_SESSION['user'];
            echo "
            <div class='links'>
            <ul>
            <li><h3 id='username'>$username</h3></li>
            <li><a href='date.html' class='btn-l'>Log out</a></li>
            </ul>
            </div>
            ";
        ?>
        
        </p>
        

        
        <div class='calender'>
            <div class='calendar_left'>
                <div class='header'>
                    <h2 id='year'></h2>
                </div>
                <div class='header'>
                    <i class='material-icons' id='prev'>navigate_before</i>
                    <h1 id='month_abr'></h1>
                    <i class='material-icons' id='next'>navigate_next</i>
                </div>
                <div class='days'>
                    <div class='day_item'>Mon</div>
                    <div class='day_item'>Tue</div>
                    <div class='day_item'>Wed</div>
                    <div class='day_item'>Thu</div>
                    <div class='day_item'>Fri</div>
                    <div class='day_item'>Sat</div>
                    <div class='day_item'>Sun</div>
                </div>
                <div class='dates' id='dates'></div>
            </div>

            <div class='calender_right' id='calender_right'>
                
                <div id='new_event' class='new_event'>
                    <select placeholder='type of calender' id='select'>
                        <option value='Social'>Social</option>
                        <option value='Work'>Work</option>
                    </select>             
                    <input placeholder='Enter a task for this day' type='text' id='input'></input>
                    <div class="plus radius" id='submit'></div>
                </div>
            </div>
        </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script>

function current_date(){
    
    var today=new Date();
    currentdate=[today.getFullYear(),today.getMonth()+1,today.getDate()];
    return currentdate;
}

let Syear=current_date()[0];
let Smonth=current_date()[1];
let Sday=current_date()[2];
let select_mon=Smonth;
let select_year=Syear;
let m_month=0;
let m_year=0;

function show_calender(year,month){
    document.getElementById('dates').innerHTML="";

    var week=new Date(year,month-1,0).getDay();
    var month_day=new Date(year,month,0).getDate();

    document.getElementById('year').innerHTML=year;
    document.getElementById('month_abr').innerHTML=current_month(month-1);

    if(Sday==0){
        if(m_year==year&& m_month==current_month(month-1)){
            document.getElementById('month_abr').classList.add('present1');
        }else{
            document.getElementById('month_abr').classList.remove('present1');
        }
    }


    

    if(month==1){
        last_year=year-1;
        last_month=12;
    }else{
        last_year=year;
        last_month=month-1;
    }

    var last_month_day=new Date(last_year,last_month,0).getDate();

    for(var i=last_month_day-week+1;i<=last_month_day;i++){
        const newdiv=document.createElement('div');
        newdiv.classList.add('prev_date_item');
        newdiv.textContent=i;
        document.getElementById('dates').appendChild(newdiv);
    }

    for(var i=1;i<=month_day;i++){
        var uidi=i;
        var uidm=month;
        var uid=uidi.toString()+uidm.toString();
        const newdiv=document.createElement('div');
        newdiv.classList.add('date_item');
        newdiv.textContent=i;
        document.getElementById('dates').appendChild(newdiv);
    }

    const boxes=document.querySelectorAll('.date_item');
    boxes.forEach(box=>{
        box.addEventListener('click',select,false);
    });

    PresentDay(year,month,Sday);


    
}

function current_month(mon){
    monthRef= ["Jan", "Feb", "Mar","Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    var monthname=monthRef[mon];
    return monthname;
}

function PresentDay(year,month,day){
    if(day!=0){
        if(year==select_year&&month==select_mon){
            document.querySelectorAll('.date_item')[day-1].classList.add('present');
        }
    }
}
    

function prev(){
    if(Smonth==1){
        Smonth=12;
        Syear=Syear-1;
    }else{
        Smonth=Smonth-1;
    }
    show_calender(Syear,Smonth);
}

function next(){
    if(Smonth==12){
        Smonth=1;
        Syear=Syear+1;
    }else{
        Smonth=Smonth+1;
    }
    show_calender(Syear,Smonth);
}

function select(){
    if(document.getElementById('month_abr').classList.contains('present1')){
        document.getElementById('month_abr').classList.remove('present1');
    }else{
        if(Smonth==select_mon && Syear==select_year && Sday!=0){
            document.getElementsByClassName('present')[0].classList.remove('present');
        }        
        
    }
    
    Sday=this.innerHTML;
    select_mon=Smonth;
    select_year=Syear;
    m_month=0;
    m_year=0;
    PresentDay(Syear,Smonth,Sday);
    updateCalender();
}

const username=document.getElementById("username").textContent;

function getEventArray(day,month,year,username){
    
    const data={'year':year,'month':month,'day':day,'username':username};

    fetch("get_events.php", {
        method: 'POST',
        body: JSON.stringify(data),
        headers: { 'content-type': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        let event_array = helpEventArray (data);
        updateEvent(event_array);
    })
    .catch(error => console.error('Error:',error))
}

function helpEventArray (data) {
    var events = [];
    if (data.success == true) {      
        let ids = data.ids;
        let names = data.names;
        let categorials = data.categorials;
        let indexs=data.indexs;
        for (i = 0; i < names.length; i++) {
            let new_event = new event (ids[i], names[i], categorials[i],indexs[i]);
            
            events.push (new_event);

        }
    }
    return events;
}

function updateEvent(event_array){
    const R= document.getElementById('calender_right');  
    const newdiv=document.createElement('div');
    newdiv.classList.add('list');
    R.insertBefore(newdiv,R.children[0]);
    
    for(i=0;i<event_array.length;i++){
        const newli=document.createElement('li');
        newli.classList.add('bounce-in');
        newli.setAttribute("id",event_array[i].id);
        document.getElementsByClassName('list')[0].appendChild(newli);
        const newspan=document.createElement('span');
        newspan.classList.add('type');
        newspan.textContent=event_array[i].categorial;
        document.getElementsByClassName('bounce-in')[i].appendChild(newspan);
        const newinput=document.createElement('input');
        newinput.setAttribute('type',"checkbox");
        newinput.classList.add('checkbox');
        newinput.checked=transform(event_array[i].index);
        document.getElementsByClassName('bounce-in')[i].appendChild(newinput);
        const newspan1=document.createElement('span');
        if(event_array[i].index==0){
            newspan1.classList.add('description');
        }else{
            newspan1.classList.add('description');
        }
        
        newspan1.textContent=event_array[i].name;
        document.getElementsByClassName('bounce-in')[i].appendChild(newspan1);
        const newi=document.createElement('i');
        newi.classList.add('fas', 'fa-trash-alt','icon_trash');
        document.getElementsByClassName('bounce-in')[i].appendChild(newi);
        const newi1=document.createElement('i');
        newi1.classList.add('fas','fa-edit','icon');
        document.getElementsByClassName('bounce-in')[i].appendChild(newi1);
    }

    const boxes1=document.querySelectorAll('.fa-trash-alt');
    boxes1.forEach(box=>{
        box.addEventListener('click',function(event){
            wTile=event.target.parentNode;
            delete_event(wTile.id);
        },false);
    });


    const boxes2=document.querySelectorAll('.fa-edit');
    boxes2.forEach(box=>{
        box.addEventListener('click',function(event){
            wTile=event.target.parentNode.children[2];
            wTile.contentEditable="true";
        },false);
    })

    const boxes3=document.querySelectorAll('.description');
    boxes3.forEach(box=>{
        box.addEventListener('keydown',function(e){
            if(e.keyCode == 13 && e.target.textContent != ""){
                e.preventDefault();
                e.target.contentEditable="false";
                wTile=e.target.parentNode;
                edit_event(wTile.id,e.target.textContent);
            }
        },false);
    })

    const boxes4=document.querySelectorAll('.checkbox');
    boxes4.forEach(box=>{
        box.addEventListener('click',function(e){
            wTile=e.target.parentNode;
            if_finished(wTile.id,e.target.checked);
        },false);
    })
    
    

}



function updateCalender(){
    const right_div=document.getElementById('calender_right');
    if(right_div.childElementCount>1){
        right_div.removeChild(right_div.children[0]);
    }else{
        if(right_div.children[0].id != 'new_event'){
            right_div.innerHTML="";
            right_div.innerHTML="";
            const input_div=document.createElement('div');
            input_div.classList.add('new_event');
            input_div.setAttribute("id","new_event");
            right_div.appendChild(input_div);
            const input_select=document.createElement('select');
            input_select.setAttribute("id","select");
            document.getElementById('new_event').appendChild(input_select);
            const input_option=document.createElement('option');
            input_option.setAttribute("value","Social");
            input_option.textContent="Social";
            document.getElementById('select').appendChild(input_option);
            const input_option1=document.createElement('option');
            input_option1.setAttribute("value","Work");
            input_option1.textContent="Work";
            document.getElementById('select').appendChild(input_option1);
            const input_input=document.createElement('input');
            input_input.setAttribute("placeholder","Enter a task for this day");
            input_input.setAttribute("type","text");
            input_input.setAttribute("id","input");
            document.getElementById('new_event').appendChild(input_input);
            const input_div1=document.createElement('div');
            input_div1.classList.add('plus','radius');
            input_div1.setAttribute("id","submit");
            document.getElementById('new_event').appendChild(input_div1);

            document.getElementById('submit').addEventListener('click',function(e){
                w=e.target.parentNode.children[1];
                if(w.value!=""){
                    add_event();
                }
            },false);
        
            


    }
}
    
    const username=document.getElementById("username").textContent;
    getEventArray(Sday,select_mon,select_year,username);
}

function event (id, name, categorial,index) {
    this.name = name;
    this.id = id;
    this.categorial = categorial;
    this.index=index;
}


function add_event(){
    
    const event_name=document.getElementById('input').value;
    let categorial=document.getElementById('select').value;
    const username1=document.getElementById("username").textContent;

    const data={
        'event_name': event_name,
        'year': select_year,
        'month': select_mon,
        'day': Sday,
        'categorial': categorial,
        'username':username1
    };

    fetch("new_event.php", {
            method: 'POST',
            body: JSON.stringify(data),
            headers: { 'content-type': 'application/json' }
        })
        .then(response => response.json())
        .then(data => alert(data.success ? "Event has been added!" : `Error: event has not been added.`))
        .catch(error => console.error('Error:',error));

    updateCalender();

    

}

function delete_event(id){
    const data={
        'id':id
    }

    fetch("delete_event.php", {
            method: 'POST',
            body: JSON.stringify(data),
            headers: { 'content-type': 'application/json' }
        })
        .then(response => response.json())
        .then(data => alert(data.success ? "Event has been deleted!" : `Error: event has not been deleted.`))
        .catch(error => console.error('Error:',error));
        
    if(document.querySelectorAll('.present1')!=0){
        show_month();
    }else{
        updateCalender();
    }
}

function edit_event(id,title){
    const data={
        'id':id,
        'title':title
    }

    fetch("edit_event.php", {
            method: 'POST',
            body: JSON.stringify(data),
            headers: { 'content-type': 'application/json' }
        })
        .then(response => response.json())
        .then(data => alert(data.success ? "Event has been edited!" : `Error: event has not been edited.`))
        .catch(error => console.error('Error:',error));
    
    if(document.querySelectorAll('.present1')!=0){
        show_month();
    }else{
        updateCalender();
    }
    


}

function if_finished(id,y_or_n){
    if(y_or_n == true){
        index=1;
    }else{
        index=0;
    }
    const data={
        'id':id,
        'if_finished':index
    }

    fetch("if_event.php", {
            method: 'POST',
            body: JSON.stringify(data),
            headers: { 'content-type': 'application/json' }
        })
        .then(response => response.json())
        .catch(error => console.error('Error:',error));
        
    
    
}

function transform(index){
    if(index==0){
        return false;
    }else{
        return true;
    }
}

function show_month(){
    Sday=0;
    m_year=document.getElementById('year').textContent;
    m_month=document.getElementById('month_abr').textContent;
    document.getElementById('calender_right').innerHTML="";
    if(document.querySelectorAll('.present').length !=0 ){
        document.getElementsByClassName('present')[0].classList.remove('present');
        
    }
    document.getElementById('month_abr').classList.add('present1');

    const username2=document.getElementById("username").textContent;
    const data={
        'year': Syear,
        'month':Smonth,
        'username':username2
    }

    fetch("month_events.php", {
        method: 'POST',
        body: JSON.stringify(data),
        headers: { 'content-type': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        let event_array = helpEventArray (data);
        updateEvent(event_array);
    })
    .catch(error => console.error('Error:',error))

}
</script>
        

    <script>
        document.addEventListener("DOMContentLoaded", show_calender(Syear,Smonth), false);
        document.addEventListener('DOMContentLoaded',updateCalender(),false);
        document.getElementById("prev").addEventListener("click",prev,false);
        document.getElementById("next").addEventListener("click",next,false);
        document.getElementById('submit').addEventListener('click',function(e){
            
            w=e.target.parentNode.children[1];
            if(w.value!=""){
                add_event();
            }
                
        },false);

        document.getElementById('month_abr').addEventListener('click',function(){
            show_month();
        },false);
        
        
    </script>     

        
        

        

    </body>


</html>