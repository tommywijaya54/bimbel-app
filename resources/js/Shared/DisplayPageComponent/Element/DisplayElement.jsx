import { DisplayFields, getAlias } from "@/util";

Array.prototype.findById = function(id){
    return this.find(x => x.id === id);
}

const displayValueElement = (data,el) => {
    let value = data[el.entityname];

    if(Array.isArray(value)){
        if(value.length == 0){
            return <span className="empty-value">---</span>
        }
        return value.map((a,i) => {
            if(typeof a == 'object'){
                return <a key={i} href={'/'+getAlias(el.entityname)+'/'+a.id} className={getAlias(el.entityname)+' link'}>{a.name}</a>
            }else if(typeof a == 'string'){
                return <span key={i} className={getAlias(el.entityname)+" unit"}>{a}</span>
            }
        })
    }

    /*
    if(el.entityname == 'student'){
        console.log(data,el);
        return JSON.stringify(value);
    }
    */

    

    if(value == null){
        return <span className="empty-value">---</span>
    }

    if(el.entityname === 'email'){
        return <a className="link" href={'mailto:'+value}>{value}</a>;
    }

    if(el.entityname.includes('_date')){
        return (new Date(value)).toLocaleDateString(locale.code,locale.dateFormat);
    }

    if(el.entityname === 'role'){
        if(Array.isArray(value)){
            if(value.length == 0){
                return <span className="empty-value">no role assign</span>
            }
            return value.map((a,i) => <span key={i} className="role unit">{a}</span>)
        }
    }

    if(el.entityname === 'user'){
        return <a href={"/user/"+value.id} className='user link'>{value.id + " : "+value.name}</a>;
    }

    if(el.entityname === 'branch'){
        return <a href={"/branch/"+value.id} className='branch link'>{value.id + " : "+value.name}</a>;
    }
    
    try{
        if(el.entityname.includes('_id')){
            const model = el.entityname.split("_id")[0];
            const id = value;

            if(el.entityname.includes('manager_id')){
                return <a href={"/user/"+id} className='user'>{id + " : "+data[model].name}</a>;
            }

            if(el.entityname.includes('branch_id')){
                //current_app.refresh();
                /* 
                const current_data = current_app.data.props[model];
                return <a href={"/branch/"+id} className='branch link'>{id + " : "+current_data.findById(value).name}</a>;
                */
                return <a href={"/branch/"+id} className='branch link'>{id + " : "+data[model].name}</a>;
            }

            if(el.entityname.includes('user_id')){
                return <a href={"/user/"+id} className='user link'>{id + " : "+data[model].name}</a>;
            }
        }
    }catch{
        
    }

    if(typeof value === 'object'){
        return <a href={'/'+getAlias(el.entityname)+'/'+value.id} className={getAlias(el.entityname)+' link'}>{value.name}</a>

        
    }
    return value; // + " -- "+el.entityname;
}

export default ({fields, content, data, el}) => {
    if(data && el){
        return displayValueElement(data, el)
    }

    if(fields && content){
        const Fields = new DisplayFields(fields,content);

        return Fields.map((a, keyId) => {
            if(a.element){
                return(<div key={keyId} className={a.element+' e-element'}></div>);
            }else if(a.entityname){
                return (<div key={keyId} className="form-component pr-6 pb-8 w-full lg:w-1/2">
                            This is located at /DisplayPageComponent/Element/DisplayElement.jsx : Fields
                            <label className="form-label">{a.label}:</label> 
                            <div className="form-input">
                                {displayValueElement(content,a)}
                            </div>
                        </div>);
            }
        })
    }
}