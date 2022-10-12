import { FieldUtil } from '@/Shared/DisplayPageComponent/Field/util_field';

export default ({field,data}) => {
    if(!field.value){
        field.value = data[field.entityname];
    }
    return FieldUtil.getProcessedContent(field);
}