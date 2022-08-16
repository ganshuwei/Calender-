

function add_event(){
    const event_name=document.getElementById('new_event').value;
    let date_month=document.getElementById('month_abr');
    let date_year=document.getElementById('year');
    let date_day=Sday;
    let categorial=document.getElementById('select').value;

    let adding_event=new new_event (event_name, date_day, date_month,date_year, categorial);
    const username1=document.getElementById("username").textContent;

    const data={
        'event_name': event_name,
        'year': date_year,
        'month': date_month,
        'day': date_day,
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