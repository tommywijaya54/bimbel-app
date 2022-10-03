import { useState } from "react";

export default ({children}) => {
    const [expand, setExpand] = useState(false);
    
    setExpand('expand');
    return <div className={"expanable "+expand}>
        {children}
    </div>;
}