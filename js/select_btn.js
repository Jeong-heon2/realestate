function btnSelect(btn,group){
    var pressed = btn.getAttribute("aria-pressed");
    if(pressed === "true"){
        btnSelectNo(btn,group);
    }else {
        btnSelectOk(btn);
    }
}
function btnSelectOk(btn){
    btn.setAttribute("aria-pressed", "true");
    btn.style.backgroundColor = "#326CF9";
    btn.style.color = "#ffffff";
    btn.style.borderColor = "#326CF9";
    settingMap();
}
function btnSelectNo(btn,group){
    var btns = document.getElementsByClassName("btn_select");
    var cnt = 0;
    if(group === 1){
        for (var i = 0 ; i < 5; i++){
            if (btns.item(i).getAttribute("aria-pressed") === "true"){
                cnt++;
            }
        }
    }else if(group === 2){
        for (var i = 5 ; i < 9 ; i++){
            if (btns.item(i).getAttribute("aria-pressed") === "true"){
                cnt++;
            }
        }
    }else if(group === 3){
        for (var i = 9 ; i < btns.length ; i++){
            if (btns.item(i).getAttribute("aria-pressed") === "true"){
                cnt++;
            }
        }
    }
    if(cnt <= 1){
        return ;
    }
    btn.setAttribute("aria-pressed", "false");
    btn.style.backgroundColor = "#ffffff";
    btn.style.color = "#000000";
    btn.style.borderColor = "darkgray";
    settingMap();
}
function settingMap(){
    var arr = [];
    var btns = document.getElementsByClassName("btn_select");
    for (var i = 0 ; i < btns.length; i++){
        if (btns.item(i).getAttribute("aria-pressed") === "true"){
            arr.push(true);
        }else{
            arr.push(false)
        }
    }
    for(var i = 0 ; i < houses.length ; i++){
        houses[i].settingMap(arr);
    }
}
function btnSelectAll(){
    var btns = document.getElementsByClassName("btn_select");
    for (var i = 0 ; i < btns.length; i++){
        var btn = btns.item(i);
        btn.setAttribute("aria-pressed", "true");
        btn.style.backgroundColor = "#326CF9";
        btn.style.color = "#ffffff";
        btn.style.borderColor = "#326CF9";
    }
    for (var i = 0 ; i < houses.length; i++){
        houses[i].displayItems();
    }
}
function btnSearch(){
    btnSelectAll();
    var input_search = document.getElementById("input_search");
    var line = input_search.value;
    for (var i = 0 ; i < houses.length; i++){
        houses[i].house_search(line);
    }
    input_search.value = "";
}