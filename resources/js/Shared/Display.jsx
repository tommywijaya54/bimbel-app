export default ({header, content, show, children}) => {
    const newContent = [];
    const display = show.split(",");

    if(content){
        for(const props in content){
            if(display.includes(props)){
                newContent.push({
                    label:props.cap(),
                    content: content[props]
                });
            }
        }
    }

    return (
        <div className="p-8 -mr-6 -mb-8 flex flex-wrap">
            {
                newContent.map((a) => {
                    return (<div className="pr-6 pb-8 w-full lg:w-1/2">
                            <label className="form-label">{a.label}:</label> 
                            <div className="form-input">{a.content}</div>
                        </div>);
                })
            }
            {children}
        </div>
    );
}