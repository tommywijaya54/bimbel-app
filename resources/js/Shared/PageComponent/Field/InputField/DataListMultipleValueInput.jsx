import { remove } from 'lodash';
import React, { useEffect, useState } from 'react';
import Icon from '../../../Icon';

export default ({name, errors = [], options, Field, setData, onChange, value, required, ...props }) => {
  
  const handleFocus = (event) => event.target.select();
  const [selectedInput, setSelectedInput] = useState(Field.value ? Field.value.split(',') : []);

  const handleOnInput = (e) => {
    const val = e.target.value;
    const opts = e.target.list.childNodes; 
    for (var i = 0; i < opts.length; i++) {
      if (opts[i].value === val) {
        listMg.add(opts[i].dataset.valueid);
        e.target.value = "";
        break;
      }
    }
  }

  useEffect(() => {
    setData(name, selectedInput.join(','));
  },[selectedInput])

  const listMg = {
    add(id){
      const itemset = new Set([...selectedInput, id]);
      setSelectedInput([...itemset]);
    },
    remove(id){
      setSelectedInput(selectedInput.filter(i => i != id));
    }
  }

  const ListValue = ({ list, getterProp, id, renderItem}) => {
    const item = list.find(i => {
        return i[getterProp] == id
    });

    return item ? renderItem(item) : id;
  }
  
  const renderPeople = (item) => {
    return <span className='bg-gray br-1 p-2 mr-2 mb-2 inline-block'>{item.name} 
              <button type="button" className='ml-2 delete-button' onClick={e => listMg.remove(item.id)}>
                  <Icon name="trash" className="block w-4 h-4 text-slate-600 fill-current"></Icon>
              </button>
            </span>
  }

  return (
      <>
        <input
          type="text"
          id={name}
          name={name}
          value={value}
          onChange={onChange}
          {...props}
          className='hidden'
          />

        <input
          list={name+'_list'}
          
          id={name+"_selector"}
          name={name+"_selector"}
          
          onFocus={handleFocus}
          onInput={handleOnInput}

          className={`input-field form-input mb-2 ${errors.length ? 'error' : ''}`}        
        />
        <datalist id={name+'_list'} >
            {options.map((option, keyId) => {
              return  <option key={keyId} data-valueid={option.id} value={option.name}></option>
            })}
        </datalist>

        {selectedInput && selectedInput.map((r,k) => {
          return <ListValue id={r} key={k} list={options} getterProp="id" renderItem={renderPeople}></ListValue>
        })}

      {errors && <div className="form-error">{errors}</div>}
    </>
  );
};
