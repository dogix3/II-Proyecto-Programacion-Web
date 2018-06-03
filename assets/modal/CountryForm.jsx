var Form = Reactstrap.Form;
var Button = Reactstrap.Button;
var FormGroup = Reactstrap.FormGroup;
var Label = Reactstrap.Label;
var Input = Reactstrap.Input;
var ButtonGroup = Reactstrap.ButtonGroup;

class CountryForm extends React.Component {
    constructor(props) {
        super(props)
        this.state = {id:"",name:"",area:0,population:0,density:0}
        this.state = {id2:"",name2:"",area2:0,population2:0,density2:0}
        this.handleInsert = this.handleInsert.bind(this);
        this.handleUpdate = this.handleUpdate.bind(this);
        this.handleDelete = this.handleDelete.bind(this);
        this.handleFields = this.handleFields.bind(this);
        this.setButtons = this.setButtons.bind(this);
        this.getState = this.getState.bind(this);
    }
    componentWillReceiveProps(nextProps) {
        this.setState({id:nextProps.country.id});
        this.setState({name:nextProps.country.name});
        this.setState({area:nextProps.country.area});
        this.setState({population:nextProps.country.population});
        this.setState({density:nextProps.country.density});
    }
    handleInsert() {
        fetch("./server/index.php/country/"+this.state.id2,{
             method: "post",
             headers: {'Content-Type': 'application/json'},
             body: JSON.stringify({
                 method: 'put',
                 name: this.state.name2,
                 area: this.state.area2,
                 population: this.state.population2,
                 density: this.state.density2
                        })
     }).then((response) => {
            this.props.handleChangeData();
            this.props.handleEditData(false);
        }
    );
    }
    handleUpdate() {
        fetch("./server/index.php/country/"+this.state.id,{
            method: "post",
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                name: this.state.name,
                area: this.state.area,
                population: this.state.population,
                density: this.state.density
            })
      }).then((response) => {
            this.props.handleChangeData();
            this.props.handleEditData(); // funciona
        }
    );
    }
    handleDelete() {
        fetch("./server/index.php/country/"+this.state.id,{
            method: "post",
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ method: 'delete'})
        }).then((response) => {
            this.props.handleChangeData();
            this.props.handleEditData(false);
        }
    );
    }
    handleFields(event) {
        const target = event.target;
        const value = target.value;
        const name = target.name;
        this.setState({[name]: value});
    }
    setButtons(){
    	if (this.props.nuevo==true) {
    		return (<ButtonGroup><Button color="primary" onClick={this.handleInsert}>Agregar</Button>{' '}</ButtonGroup>);
    	}else{
    		return (<ButtonGroup><Button color="danger" onClick={this.handleDelete}>Eliminar</Button>
            		<Button color="primary" onClick={this.handleUpdate}>Modificar</Button></ButtonGroup>)
    	}
    }
    getState(val){
    	if (this.props.nuevo==true) {
    		return '';
    	}else{
    		return (val);
    	}
    }
    setForm(){
    	if (this.props.nuevo==true) {
    		return (<Form color="primary">
	            <FormGroup><Label>Nombre:</Label>
	                <Input type="text" name="name2"
	                    value={this.state.name2} onChange={this.handleFields}/></FormGroup>
	            <FormGroup><Label>Area:</Label>
	                <Input type="text" name="area2"
	                    value={this.state.area2} onChange={this.handleFields}/></FormGroup>
	             <FormGroup><Label>Population:</Label>
	                <Input type="text" name="population2"
	                    value={this.state.population2} onChange={this.handleFields}/></FormGroup>
	            <FormGroup><Label>Density:</Label>
	                <Input type="text" name="density2"
	                    value={this.state.density2} onChange={this.handleFields}/></FormGroup>
	            <Input type="hidden" name="id2" value={this.state.id2}/>
	        </Form>);
	    }else{
	    	return (<Form color="primary">
	            <FormGroup><Label>Nombre:</Label>
	                <Input type="text" name="name"
	                    value={this.state.name} onChange={this.handleFields}/></FormGroup>
	            <FormGroup><Label>Area:</Label>
	                <Input type="text" name="area"
	                    value={this.state.area} onChange={this.handleFields}/></FormGroup>
	             <FormGroup><Label>Population:</Label>
	                <Input type="text" name="population"
	                    value={this.state.population} onChange={this.handleFields}/></FormGroup>
	            <FormGroup><Label>Density:</Label>
	                <Input type="text" name="density"
	                    value={this.state.density} onChange={this.handleFields}/></FormGroup>
	            <Input type="hidden" name="id" value={this.state.id}/>
	        </Form>);
	    }
 
    }
    render() {
         return(<Modal isOpen={this.props.modal} toggle={this.props.handleEditData} className={this.props.className}>
          <ModalHeader toggle={this.handleEditData}>Información de país</ModalHeader>
          <ModalBody>
          	{this.setForm()}
          </ModalBody>
          <ModalFooter>
            	{this.setButtons()}
            	<Button color="secondary" onClick={this.handleEditData}>Cancelar</Button>
          </ModalFooter>
            </Modal>)
     }
 }

class SSS {
	/*
<Form color="primary">
            <FormGroup><Label>Nombre:</Label>
                <Input type="text" name="name"
                    value={this.getState("name")} onChange={this.handleFields}/></FormGroup>
            <FormGroup><Label>Area:</Label>
                <Input type="text" name="area"
                    value={this.getState(this.state.area)} onChange={this.handleFields}/></FormGroup>
             <FormGroup><Label>Population:</Label>
                <Input type="text" name="population"
                    value={this.getState(this.state.population)} onChange={this.handleFields}/></FormGroup>
            <FormGroup><Label>Density:</Label>
                <Input type="text" name="density"
                    value={this.getState(this.state.density)} onChange={this.handleFields}/></FormGroup>
            <Input type="hidden" name="id" value={this.state.id}/>
            </Form></ModalBody>
 */
}