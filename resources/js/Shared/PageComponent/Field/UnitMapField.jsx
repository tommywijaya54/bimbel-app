export default ({map, header, className, wrapperClassName}) => {

    // wrapperClassName = "ui-component row max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6 row";

    if(typeof header == 'string'){
        header = <h2 className="text-lg">{header}</h2>
    }

    return (<div className={wrapperClassName}>
        {header && header}
        {(!map || map.length === 0) ? 
            <span className="empty-value">---</span> :
            map.map((unit,keyid) => {
                if(typeof unit === 'object'){
                    return <span key={keyid} className={'unit '+className}>{unit.name}</span>
                }
               return <span key={keyid} className={'unit '+className}>{unit}</span>
            })
        }
    </div>)
}