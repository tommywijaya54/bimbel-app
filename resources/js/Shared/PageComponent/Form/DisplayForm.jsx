import ValueField from "../Field/ValueField";

export default ({fields}) => {
    return fields.map((field,keyId) => {
        return <ValueField Field={field} key={keyId}></ValueField>
    })
}