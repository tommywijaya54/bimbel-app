export default ({data, el, a}) => {
    let text = el.content;
    if(data){
        text = data[el.entityname];
    }
    //if(data){
    //const text = data[el.entityname];
    if(el.entityname == 'email'){
        return <a className="link" href={'mailto:'+text}>{text}</a>;
    }
    return text;
}