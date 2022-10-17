import { FieldUtil } from '@/Shared/Util/Field_util';

export default ({field}) => {
    const {entityname, value, inputtype} = field;


    if(entityname.includes('date')){
        return <div className='no-wrap'>{(new Date(value)).toLocaleDateString(locale.code,locale.dateFormat)}</div>;
    }

    if(entityname.includes('note')){
        return <div className='inline-note'>{value}</div>;
    }

    if(entityname.includes('amount') || entityname.includes('cost')){
        return <span className='currency'>
            <span className='sign'>{locale.currency.sign || '$'}</span>
            {value.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')}
        </span>
    }

    return value; 
}