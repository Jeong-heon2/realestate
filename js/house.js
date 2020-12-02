class House {
    // PersonType 생성자와 동일합니다.
    constructor(id,type, address, explanation, deal_type, price, area_m2, direction, title, overlay) {
        this.id = id;
        this.type = type;
        this.deal_type = deal_type;
        this.address = address;
        this.price = price;
        this.explanation = explanation;
        this.area_m2 = area_m2;
        this.direction = direction;
        this.title = title;
        this.overlay = overlay;
    }
    settingMap(arr){
        //type 12345 아파트 주택 원룸 오피스텔 건물
        if(this.type === "1"){
            if (!arr[0]){
                this.displayNull();
                return ;
            }
        }else if(this.type === "2"){
            if (!arr[4]){
                this.displayNull();
                return ;
            }
        }else if(this.type === "3"){
            if (!arr[3]){
                this.displayNull();
                return ;
            }
        }else if(this.type === "4"){
            if (!arr[1]){
                this.displayNull();
                return ;
            }
        }else if(this.type === "5"){
            if (!arr[2]){
                this.displayNull();
                return ;
            }
        }
        //dealtype 123 월전매
        if(this.deal_type === "1"){
            if (!arr[11]){
                this.displayNull();
                return ;
            }
        }else if(this.deal_type === "2"){
            if (!arr[10]){
                this.displayNull();
                return ;
            }
        }if(this.deal_type === "3"){
            if (!arr[9]){
                this.displayNull();
                return ;
            }
        }
        //direction 1234 동서남북
        if(this.direction === "1"){
            if (!arr[6]){
                this.displayNull();
                return ;
            }
        }else if(this.direction === "2"){
            if (!arr[7]){
                this.displayNull();
                return ;
            }
        }else if(this.direction === "3"){
            if (!arr[5]){
                this.displayNull();
                return ;
            }
        }else if(this.direction === "4"){
            if (!arr[8]){
                this.displayNull();
                return ;
            }
        }

        this.displayItems();
    }
    displayNull(){
        this.overlay.setMap(null);
    }
    displayItems(){
        this.overlay.setMap(map);
    }
    house_search(line){
        const re = /\s/gi;
        line = line.replace(re, "");
        if(line.length !== 0){
            let regex = RegExp('.*'+line+'+');
            let title_n = this.title.replace(re, "");
            let address_n = this.address.replace(re, "");
            let exp_n = this.explanation.replace(re, "");
            if(!regex.test(title_n)  && !regex.test(address_n) &&!regex.test(exp_n)){
                this.displayNull();
            }
        }
    }

}