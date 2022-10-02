import React, { useState } from "react";



const AutoCompleteInput = ({Users, Me, Options}) => {
    // Creating Autocomplete box for search user
    const [suggestions, setSuggestions] = useState([]);
    const [suggestionIndex, setSuggestionIndex] = useState(0);
    const [suggestionsActive, setSuggestionsActive] = useState(false);
    const [value, setValue] = useState("");

    const handleChange = (e) => {
        const query = e.target.value.toLowerCase();
        setValue(query);

        if(query.length > 0){
            // ToDo: suggestions should be array of users
            const filterSuggestions = Users.filter((suggestion) => suggestion.name.toLowerCase().indexOf(query) > -1);
            
            console.table(filterSuggestions);

            setSuggestions(filterSuggestions);
            setSuggestionsActive(true);
        }else{
            setSuggestionsActive(false);
        }
    }

    const handleClick = (e) => {
        setSuggestions([]);
        setValue(e.target.innerText);
        setSuggestionsActive(false);
    }

    const handleKeyDown = (e) => {
        // UP ARROW
        if (e.keyCode === 38) {
            if (suggestionIndex === 0) {
            return;
            }
            setSuggestionIndex(suggestionIndex - 1);
        }
        // DOWN ARROW
        else if (e.keyCode === 40) {
            if (suggestionIndex - 1 === suggestions.length) {
            return;
            }
            setSuggestionIndex(suggestionIndex + 1);
        }
        // ENTER
        else if (e.keyCode === 13) {
            setValue(suggestions[suggestionIndex].name);
            setSuggestionIndex(0);
            setSuggestionsActive(false);
        }
    };

    const Suggestions = () => {
        return <>
            <ul className="suggestions">
                {
                    suggestions.map((suggestion,index) => {
                        return (
                            <li
                                className={index === suggestionIndex ? "active" : ""}
                                key={index}
                                onClick={handleClick}
                            >
                                {suggestion.name}
                            </li>
                        )
                    })
                }
            </ul>
        </>
    }

    return <>
        <div className='py-4 bg-indigo-300'>
            <div className='autocomplete text-black'>
                <input
                    type="text"
                    value={value}
                    onChange={handleChange}
                    onKeyDown={handleKeyDown}
                    placeholder="Search or start new chat"
                    className="w-full"
                />
                {suggestionsActive && <Suggestions />}
            </div>
        </div>
    </>
}
export default AutoCompleteInput;
