import DisplayElement from "./DisplayElement";

export default ({header, content, fields, children}) => {
    const newContent = [];
    const display = fields.split(",");
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
                    content: content[prp],
                    ...a
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
        <div className="display-component flex flex-wrap ">
            {
                newContent.map((a, keyId) => {
                    if(a.element && a.element == 'blank row'){
                        return(<div key={keyId} className="blank-row w-full"></div>)
                    }else if(a.element && a.element == 'line'){
                        return(<div key={keyId} className="line w-full"></div>)
                    }else{
                        return (<div key={keyId} className="pr-6 pb-8 w-full lg:w-1/2">
                                    <label className="form-label">{a.label}:</label> 
                                    <div className="form-input">
                                        <DisplayElement data={content} el={a}></DisplayElement>
                                    </div>
                                </div>);
                    }
                })
            }
            {children}
        </div>
    );
}