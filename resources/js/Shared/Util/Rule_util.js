
/* 
var rule_date = new Rule('entityname','includes',['amount','qty'],(v) => { v.input_type = 'number' });

let Rules = new RuleSet();
Rules.add(new Rule('entityname','includes',['amount','qty'],(v) => {v.input_type = 'number'}));
Rules.add(new Rule('entityname','includes',['date'],(v) => {v.input_type = 'date'}));

var a = {
    entityname:'open_date',
    value:'2022/12/25'
}

var b = {
    entityname:'amount_payment',
    value:'2022/12/25'
}


Rules.check(a);
console.log(a);

Rules.check(b);
console.log(b);

*/

export class Rule{
    constructor(check_for,operator,arr,result){
        this.check_for = check_for;
        this.operator = operator;
        this.arr = arr;
        this.result = result;
    }
    is = (field) => {
        return this.arr.some(v => {
            return field[this.check_for][this.operator](v)
        })
    }
    run = (field) => {
        if(this.is(field)){
            if(typeof this.result == 'function'){
                this.result(field);
                return true;
            }else{
                return this.result;
            }
        }
        return false;
    }
}

export class RuleSet {
    constructor(){
        this.set = [];
        this.else = null;
    }
    add(rule){
        this.set.push(rule);
    }
    _else(fn){
        this.else = fn;
    }
    process(field){
        const finalResult = this.set.some(rule => {
            return rule.run(field);
        });

        if(this.else && !finalResult){
            this.else(field);
            return true
        }

        return finalResult
    }
}
