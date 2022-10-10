import { FieldUtil } from "../Field/util_field";
export default ({fields}) => {
    if(fields){
        return fields.map((field,keyId) => {
            return FieldUtil.getElementIfExist(field,keyId) || 
                        (<div key={keyId} className="form-component pr-6 pb-8 w-full lg:w-1/2">
                            <label className="form-label">{field.label}:</label> 
                            <div className="form-input">
                                {FieldUtil.getProcessedContent(field)}
                            </div>
                        </div>);
        })
    }
}