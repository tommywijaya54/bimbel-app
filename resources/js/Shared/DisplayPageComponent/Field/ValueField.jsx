import { FieldUtil } from '@/Shared/DisplayPageComponent/Field/util_field';

export default ({field}) => {
    const {entityname,value} = field;

    if(entityname.includes('date')){
        return <div className='no-wrap'>{(new Date(value)).toLocaleDateString(locale.code,locale.dateFormat)}</div>;
    }

    if(entityname.includes('amount') || entityname.includes('cost')){
        return <span className='currency'>
            <span className='sign'>{locale.currency.sign || '$'}</span>
            {value.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')}
        </span>
    }

    return value; 
}