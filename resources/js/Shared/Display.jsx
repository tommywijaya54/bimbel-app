export default ({header, content, show, children}) => {
    const newContent = [];
    const display = show.split(",");
    if(content){
        display.forEach((prp) => {
            if(prp == ''){
                newContent.push({
                    element:'blank row'
                })
            }else if(prp == '_'){
                newContent.push({
                    element:'line'
                })
            }else{

                const a = prp.toDisplayElement();

                newContent.push({
                    label:a.label,
                    content: content[prp]
                })
            }
        })

        /* 
        for(const props in content){
            if(display.includes(props)){
                newContent.push({
                    label:props.cap(),
                    content: content[props]
                });
            }
        }
        */
    }

    return (
        <div className="-mr-6 -mb-8 flex flex-wrap display-component">
            {
                newContent.map((a, keyId) => {
                    if(a.element && a.element == 'blank row'){
                        return(<div key={keyId} className="blank-row w-full"></div>)
                    }else if(a.element && a.element == 'line'){
                        return(<div key={keyId} className="line w-full"></div>)
                    }else{
                        return (<div key={keyId} className="pr-6 pb-8 w-full lg:w-1/2">
                                    <label className="form-label">{a.label}:</label> 
                                    <div className="form-input">{a.content}</div>
                                </div>);
                    }
                })
            }
            {children}
        </div>
    );
}