import { FieldUtil } from "../../Util/Field_util";
export default ({fields}) => {
    return fields.map((field,keyId) => {
        return FieldUtil.getElementIfExist(field,keyId) || 
                    (<div key={keyId} className="form-component pr-6 pb-4 w-full lg:w-1/2">
                        <label className="form-label">{field.label}:</label> 
                        <div className="form-input">
                            {FieldUtil.getProcessedContent(field,keyId)}
                        </div>
                    </div>);
    })
}