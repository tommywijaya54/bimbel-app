export default ({data, el}) => {
    let text = data[el.entityname];

    /*
    let text = el.content;

    if(data){
        
    }
    */

    /* 
    
    */
   
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

      

    return text;// + " -- "+el.entityname;
}