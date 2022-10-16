import React from "react";
import { Rule, RuleSet } from "./Rule_util";

function getAlias(str){
    const alias = {
        'cparent' : 'parent'
    }
    
    if(str.includes('_id')){
        str = str.replace('_id','');
    }

    return alias[str] || str
}

class Field{
    constructor(strField){
        if(!strField){
            this.element = 'row'
        }else if(strField === '_'){
            this.element = 'line'
        }else{
            if(strField.includes(':')){
                const xo = strField.split(':');
                this.entityname = xo[0],
                this.label = (xo[1]||xo[0].cap())
            }else{
                this.entityname = strField;
                this.label = strField.cap();
            }
        }
    }
    setValueFrom(data){
        if(this.entityname){
            this.value = data[this.entityname];
        }
    }  
}

class FieldUtil{
    static createFields_setData(strFields,data){
        const Fields = FieldUtil.turnStringToArrayOfField(strFields);
        
        Fields.forEach(Field => {
            Field.setValueFrom(data);
        });

        return Fields;
    }
    
    // Turn String of Fields to Field of array
    static turnStringToArrayOfField (stringOfFields){
        return stringOfFields.split(',').map(strField => new Field(strField));
    }

    // True Field value to HTML element (if : field.entityname exist)
    static getProcessedContent(field, key){
        let value = field.value;

        if(field.model){
            return React.createElement('a',{
                href:'/'+getAlias(field.entityname)+'/'+value,
                className:getAlias(field.entityname)+' link',
                key:key
            },field.model_value.name);
        }

        if(value == null || value == '' || value.length == 0){
            return React.createElement('span',{
                className:"empty-value",
                key:key
            },'---');
        }

        if(typeof value == 'string'){
            if(field.entityname === 'email'){
                return React.createElement('a',{
                    href:'mailto:'+value,
                    className:getAlias(field.entityname)+' link',
                    key:key
                },value);
            }

            if(field.entityname.includes('date')){
                return (new Date(value)).toLocaleDateString(locale.code,locale.dateFormat);
            }
        }

        if(typeof value == 'number'){
            if(field.entityname.includes('amount') || field.entityname.includes('cost')){
                return React.createElement('span',{
                    className:'currency',
                    key:key
                },[
                    React.createElement('span',{
                        className:'sign',
                        key:key
                    },locale.currency.sign),
                    field.value.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                ]);
            }
        }

        if(Array.isArray(value) && value.length > 0){
            return value.map((x,keyId) => {
                let value = typeof x == 'string' ? x : x.name;
                return React.createElement('span',{
                    key:keyId,
                    className:field.entityname+" unit",
                    key:key
                },value);
            })
        }

        if(typeof value === 'object'){
            return React.createElement('a',{   
                href:'/'+getAlias(field.entityname)+'/'+value.id, 
                className:getAlias(field.entityname)+' link',
                key:key
            },value.name);
        }
        
        return value;
    }

    // return HTML element (if field is element of row or line)
    static getElementIfExist(field, keyId){
        if(field.element){
             if(field.element == 'row'){
                return React.createElement('div', {className:'row w-full', key:keyId}, '');
            }else if(field.element == 'line'){
                return React.createElement('div', {className:'line w-full', key:keyId}, '');
            }
        }
        return null;
    }

    static Rules = (() => {
        
        let FieldRules = new RuleSet();

        // process input type
        FieldRules.add(new Rule('entityname','includes',['amount','qty','cost'],(field) => field.input_type = 'number'));
        FieldRules.add(new Rule('entityname','includes',['date'],(field) => field.input_type = 'date'));
        FieldRules._else((field) => field.input_type = 'text' );

        FieldRules.processFields = (fields) => {
            fields.forEach((field) => FieldRules.process(field));
        }

        return FieldRules;
    })();


    static processWithRules(field){

    }
}

export {FieldUtil}