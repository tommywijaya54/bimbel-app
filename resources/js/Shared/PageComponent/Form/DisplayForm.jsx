import ValueField from "../Field/ValueField";

export default ({fields}) => {
    return fields.map((field,keyId) => {
        return <ValueField field={field} key={keyId}></ValueField>
    })
}