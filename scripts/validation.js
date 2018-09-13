window.onload = function()
{
document.getElementById("authForm").onsubmit = function(){ Validation() };

function Validation()
{
    var login = document.getElementById("UserLogin").value;
    var password = document.getElementById("UserPassword").value;

        if(login == '' && password == '')
        {
            alert('Все поля должны быть заполнены!');
            event.preventDefault();
        }
        if(login != 'root' || password != 'root')
        {
            alert('Пользователя с такими даннными не существует!');
            event.preventDefault();
        }
}
}