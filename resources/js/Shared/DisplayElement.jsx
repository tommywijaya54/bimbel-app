import { DisplayFields, getAlias } from "@/util";

Array.prototype.findById = function(id){
    return this.find(x => x.id === id);
}

const displayValueElement = (data,el) => {
    let text = data[el.entityname];

    if(text == null){
        return <span className="empty-value">---</span>
    }

    if(el.entityname === 'email'){
        return <a className="link" href={'mailto:'+text}>{text}</a>;
    }

    if(el.entityname.includes('_date')){
        return (new Date(text)).toLocaleDateString(locale.code,locale.dateFormat);
    }

    if(el.entityname === 'role'){
        if(Array.isArray(text)){
            if(text.length == 0){
                return <span className="empty-value">no role assign</span>
            }
            return text.map((a,i) => <span key={i} className="role unit">{a}</span>)
        }
    }

    if(el.entityname === 'user'){
        return <a href={"/user/"+text.id} className='user link'>{text.id + " : "+text.name}</a>;
    }

    if(el.entityname === 'branch'){
        return <a href={"/branch/"+text.id} className='branch link'>{text.id + " : "+text.name}</a>;
    }
    
    try{
        if(el.entityname.includes('_id')){
            const model = el.entityname.split("_id")[0];
            const id = text;

            if(el.entityname.includes('manager_id')){
                return <a href={"/user/"+id} className='user'>{id + " : "+data[model].name}</a>;
            }

            if(el.entityname.includes('branch_id')){
                //current_app.refresh();
                /* 
                const current_data = current_app.data.props[model];
                return <a href={"/branch/"+id} className='branch link'>{id + " : "+current_data.findById(text).name}</a>;
                */
                return <a href={"/branch/"+id} className='branch link'>{id + " : "+data[model].name}</a>;
            }

            if(el.entityname.includes('user_id')){
                return <a href={"/user/"+id} className='user link'>{id + " : "+data[model].name}</a>;
            }
        }
    }catch{
        
    }

    if(typeof text === 'object'){
        return <a href={'/'+getAlias(el.entityname)+'/'+text.id} className={getAlias(el.entityname)+' link'}>{text.name}</a>

        return JSON.stringify(text);
    }
      

    return text; // + " -- "+el.entityname;
}

export default ({fields, content, data, el}) => {
    if(data && el){
        return displayValueElement(data, el)
    }

    if(fields && content){
        const Fields = new DisplayFields(fields,content);

        return Fields.map((a, keyId) => {
            if(a.element && a.element == 'row'){
                return(<div key={keyId} className="blank-row w-full"></div>)
            }else if(a.element && a.element == 'line'){
                return(<div key={keyId} className="line w-full"></div>)
            }else{
                return (<div key={keyId} className="pr-6 pb-8 w-full lg:w-1/2">
                            <label className="form-label">{a.label}:</label> 
                            <div className="form-input">
                                {displayValueElement(content,a)}
                            </div>
                        </div>);
            }
        })
    }
}