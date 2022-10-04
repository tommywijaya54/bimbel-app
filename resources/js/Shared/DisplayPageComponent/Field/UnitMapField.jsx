export default ({map,header,className}) => {
    if(typeof header == 'string'){
        header = <h2 className="text-lg">{header}</h2>
    }

    return (<div className="ui-component row max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6 row">
        {header && header}
        {(!map || map.length === 0) ? 
            <span className="empty-value">---</span> :
            map.map((unit,keyid) => {
               return <span key={keyid} className={'unit '+className}>{unit}</span>
            })
        }
    </div>)
}