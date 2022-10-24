import { FieldUtil } from '@/Shared/Util/Field_util';

const FieldComponents = {
    element:{
        'row' : () => {
            return <div className='row w-full'></div>
        },
        'line' : () => {
            return <div className='line w-full'></div>
        }
    },
    inputtype:{
        'date' : ({value}) => {
            return <div className='no-wrap'>{(new Date(value)).toLocaleDateString(locale.code,locale.dateFormat)}</div>
        },
        'note' : ({value}) => {
            return <div className='inline-note'>{value}</div>
        },
        'currency' : ({value}) => {
            return  <span className='currency'>
                        <span className='sign'>{locale.currency.sign || '$'}</span>
                        {parseInt(value).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')}
                    </span>
        },
        'datalist' : (field) => {
            if(field.model_value){
                return <a href={route(field.route.show,field.model_value.id || field.value)} className={field.model + ' unit link'}>{field.model_value.name || field.value}</a>
            }
            return <a href={route(field.route.show,field.value)} className={field.model + ' unit link'}>{field.value}</a>  
        },
        'datalist-multiple-value' : (field) => {
            const ListValue = ({ list, getterProp, id}) => {
                const item = list.find(i => {
                    return i[getterProp] == id
                });
                return item ? <span className='bg-gray br-1 py-1 px-2 mr-2 mb-2 inline-block'>{item.name}</span> : id;
            }    
            return field.value?.split(',').map((val, i) => <ListValue list={field.options} getterProp='id' id={val} key={i}></ListValue>)
        },
        'text' : ({value}) => {
            return value
        },
        'email' : ({value}) => {
            return <a href={'mailto:'+value} className='email link'>{value}</a>
        },
        'multiple-checkbox' : ({value}) => {
            return value.map((val, i) => <span key={i} className='unit'>{val}</span>)
        },
        'color':({value}) => {
            return <input type="color" id="head" name="head" value={value} disabled />
        },
        'time':({value}) => {
            return value.substring(0,5);
            // return <div className='no-wrap'>{(new Date(''+value)).toLocaleDateString(locale.code,locale.timeFormat)}</div>
        }
    }
}

const FieldWrapper = ({label, children}) => {
    return  <div className="form-component pr-6 pb-4 w-full lg:w-1/2">
                <label className="form-label">{label}:</label> 
                <div className="form-input">
                    {children}
                </div>
            </div>
}

// ValueField on accept validation using inputtype NOT entityname
export default ({Field, nowrapper}) => {
    const {value, inputtype, element, label} = Field;

    if(element){
        return FieldComponents.element[element]();
    }

    if(!value){
        return  nowrapper ? 
                <span className='empty-value'>---</span> :
                <FieldWrapper label={label}>
                    <span className='empty-value'>---</span>
                </FieldWrapper>;
    }

    if(inputtype){
        return  nowrapper ? 
                FieldComponents.inputtype[inputtype] ?  FieldComponents.inputtype[inputtype](Field) : value :
                <FieldWrapper label={label}>
                    {FieldComponents.inputtype[inputtype] ?  FieldComponents.inputtype[inputtype](Field) : value}
                </FieldWrapper> 
    }

    return value; 
}