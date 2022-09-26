export default ({data, el, a}) => {
    let text = el.content;
    if(data){
        text = data[el.entityname];
    }

    if(el.entityname == 'email'){
        return <a className="link" href={'mailto:'+text}>{text}</a>;
    }

    if(el.entityname.includes('_date')){
        return (new Date(text)).toLocaleDateString(locale.code,locale.dateFormat);
    }
    
        
    if(el.entityname.includes('manager_id')){
        const str =  el.entityname.split("_")[0];
        const current_data = current_app.data.props.data;
        return <a href={"/user/"+text} className='user'>{text + " : "+current_data[str].name}</a>;
    }

    if(el.entityname.includes('branch_id')){
        const str =  el.entityname.split("_")[0];
        const current_data = current_app.data.props[str];
        return <a href={"/branch/"+text} className='branch'>{text + " : "+current_data.findById(text).name}</a>;
    }

    

    return text;// + " -- "+el.entityname;
}