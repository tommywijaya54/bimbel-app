import { usePage } from "@inertiajs/inertia-react";
import React from "react";

String.prototype.fromStringArraytoObject = function (){
    const arr = this.split(',');
    let ob = {};
    arr.map((a) => {
        ob[a] = ""
    });
    return ob;
}

// This is a list of display element object
class DisplayFields {
    constructor(fields_string,content){
        this.fields = fields_string.split(',').map(a => {
            let b = new DisplayElement(a);
            b.content = content && content[b.entityname] ? content[b.entityname] : '';
            return b;
        });

        return this.fields;
    }
}

// Display Object Class accept form_string -> object
class DisplayElement{
    constructor(elString){
        if(elString == ''){
            this.element = 'row';
        }else if(elString == '_'){
            this.element = 'line';
        }else{
            this.element = 'field';
            this.entityname = elString.split(":")[0];
            this.label = elString.split(':')[1] || this.entityname.cap();
            
            if(this.entityname.includes('_')){
                this.label = (this.entityname.split('_')).map((str) => {
                    return str.cap()
                }).join(" ");
            }

            switch (this.entityname) {
                case "id":
                    this.label = "ID";
                    break;
                case "nik":
                    this.label = "NIK";
                    break;
                case "cparent":
                    this.label = "Parent";
                    break;
            }
        }
    }
}

class FormObject {
    constructor(form_fields,data,form_fields_options){
        this.initialString = form_fields;

        this.Object = (form_fields.replace(",,",',')).fromStringArraytoObject();
        
        if(data){
            for(const property in this.Object){
                this.Object[property] = data[property] == null ? '' : data[property];
            }
        }

        this.DisplayElementInArray = (form_fields.split(',')).map((a) => {
            let DisplayEl = new DisplayElement(a);

            if(form_fields_options && form_fields_options[DisplayEl.entityname]){
                DisplayEl.label = (DisplayEl.entityname.split("_id")[0]).cap();
                DisplayEl.options = ([{id:'',name:''}]).concat(form_fields_options[DisplayEl.entityname]);
            }

            return DisplayEl;
        });
    }
}

// for URL alias : due to PHP not allow use of Parent as variable name it change to CParent
function getAlias(str){
    const alias = {
        'cparent' : 'parent'
    }
    
    if(str.includes('_id')){
        str = str.replace('_id','');
    }

    return alias[str] || str
}

// Adding Current App & Current User 
class CurrentApp{
    constructor (el_id = 'app') {
        this.el = document.getElementById(el_id);
        this.data = JSON.parse(this.el.dataset.page);
    }
    refresh(el_id = 'app') {
        this.el = document.getElementById(el_id);
        this.data = JSON.parse(this.el.dataset.page);
    }
}

class CurrentUser{
    constructor () {
        console.log(usePage());
        this.props = usePage().props;
        this.user = this.props.auth.user;

        /*

        this._app = window.current_app || new CurrentApp();
        this._data = this._app.data.props.auth.user;
        this.name = this._data.name;
        this.type = this._data.type;
        */

        this.permissions = this.props.auth.permissions;
        this.roles = this.props.auth.roles;
    }

    hasPermission(prm){
        return this.permissions.includes(prm);
    }

    hasRole(rl){
        return this.roles.includes(rl);
    }
} 

/*
window.current_app = new CurrentApp();

if(window.current_app.data.props.auth.user){
    window.current_user = new CurrentUser();
}
*/

export {DisplayFields,FormObject,DisplayElement, CurrentUser, CurrentApp, getAlias}
