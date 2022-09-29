import { getAlias } from "@/util";
import { FieldUtil } from "../util_form";

const displayElement = (field) => {
    let value = field.value;

    if(value == null || value == '' || value.length == 0){
        return <span className="empty-value">---</span>
    }

    if(typeof value == 'string'){
        if(field.entityname === 'email'){
            return <a className="link" href={'mailto:'+value}>{value}</a>;
        }

        if(field.entityname.includes('_date')){
            return (new Date(value)).toLocaleDateString(locale.code,locale.dateFormat);
        }
    }

    if(Array.isArray(value)){
        return value.map((a,i) => <span key={i} className={field.entityname + " unit"}>{a}</span>)
    }
    
    if(typeof value === 'object'){
        return <a href={'/'+getAlias(field.entityname)+'/'+value.id} className={getAlias(field.entityname)+' link'}>{value.name}</a>
    }
    
    return value;
}

const editElement = (field) => {
    return "edit "+JSON.stringify(field);
}

export default ({fields, form}) => {
    if(fields){
        return fields.map((field,keyId) => {
            return FieldUtil.check_and_getCommonField(field) || 
                        (<div key={keyId} className="pr-6 pb-8 w-full lg:w-1/2">
                            <label className="form-label">{field.label}:</label> 
                            <div className="form-input">
                                {displayElement(field)}
                            </div>
                        </div>);
        })
    }
}