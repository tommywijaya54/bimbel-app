import { getAlias } from "@/util";
import React from "react";

class Field{
    static displayElement(field){
        let value = field.value;

        
        /*
        if(field.entityname == 'users'){
            if(Array.isArray(value) && value.length > 0){
                return value.map((x,keyId) => {
                    // console.log(x,keyId,field);
                    return React.createElement('span',{
                        key:keyId,
                        className:field.entityname+" unit"
                    },x.name);
                })

                console.log(value);
                return "----X----"
            }
            // console.log(value);
            // return "null";
            /*
            return value.map((a,i) => {
                return React.createElement('span',{
                    key:{i},
                    className:field.entityname + " unit"
                },a);
            })

            // return "null";
        }*/
        /*

        if(Array.isArray(value) && value.length > 0){
            return value.map((ax,keyId) => {
                return React.createElement('span',{
                    key:{keyId},
                    className:field.entityname + " unit"
                },ax.name)
            })
        }
        */

        if(field.model){
            return React.createElement('a',{
                href:'/'+getAlias(field.entityname)+'/'+value,
                className:getAlias(field.entityname)+' link'
            },field.model_value.name);
        }

        if(value == null || value == '' || value.length == 0){
            return React.createElement('span',{
                className:"empty-value"
            },'---');
        }

        if(typeof value == 'string'){
            if(field.entityname === 'email'){
                return React.createElement('a',{
                    href:'mailto:'+value,
                    className:getAlias(field.entityname)+' link'
                },value);
            }

            if(field.entityname.includes('date')){
                return (new Date(value)).toLocaleDateString(locale.code,locale.dateFormat);
            }
        }

        if(Array.isArray(value) && value.length > 0){
            return value.map((x,keyId) => {
                let value = typeof x == 'string' ? x : x.name;
                return React.createElement('span',{
                    key:keyId,
                    className:field.entityname+" unit"
                },value);
            })
        }

        if(typeof value === 'object'){
            return React.createElement('a',{   
                href:'/'+getAlias(field.entityname)+'/'+value.id, 
                className:getAlias(field.entityname)+' link'
            },value.name);
        }
        
        return value;
    }
}

export {Field}