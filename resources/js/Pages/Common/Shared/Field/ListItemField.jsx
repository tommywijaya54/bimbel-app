import { Field } from "./util_field";

export default ({field,data}) => {
    const FieldOb = {
        ...field,
        value:data
    }
    return Field.displayElement(FieldOb);
}