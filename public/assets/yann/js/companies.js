const tableBody = document.querySelector('#table-body')
const codeBlock = `<tr>
                            <th scope="row">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                           name="chk_child"
                                           value="option1">
                                </div>
                            </th>
                            <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                                    class="fw-medium link-primary">#VZ001</a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <img src="{ asset('assets/images/companies/img-1.png') }"
                                             alt=""
                                             class="avatar-xxs rounded-circle image_src object-fit-cover">
                                    </div>
                                    <div class="flex-grow-1 ms-2 name">{ company.name }
                                    </div>
                                </div>
                            </td>
                            <td class="industry_type">{ company.category }</td>
                            <td>{ company.phone }</td>
                            <td>{ company.email }</td>
                            <td class="location">{% if company.city %} { company.city } {% endif %}{% if company.country %} , { company.country } {% endif %}</td>
                            <td>
                                <ul class="list-inline hstack gap-2 mb-0">
                                    <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                        data-bs-trigger="hover" data-bs-placement="top"
                                        title="Call">
                                        <a href="javascript:void(0);"
                                           class="text-muted d-inline-block">
                                            <i class="ri-phone-line fs-16"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                        data-bs-trigger="hover" data-bs-placement="top"
                                        title="Message">
                                        <a href="javascript:void(0);"
                                           class="text-muted d-inline-block">
                                            <i class="ri-question-answer-line fs-16"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                        data-bs-trigger="hover" data-bs-placement="top"
                                        title="View">
                                        <a href="javascript:void(0);" class="view-item-btn"><i
                                                    class="ri-eye-fill align-bottom text-muted"></i></a>
                                    </li>
                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                        data-bs-trigger="hover" data-bs-placement="top"
                                        title="Edit">
                                        <a class="edit-item-btn" href="#showModal"
                                           data-bs-toggle="modal"><i
                                                    class="ri-pencil-fill align-bottom text-muted"></i></a>
                                    </li>
                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                        data-bs-trigger="hover" data-bs-placement="top"
                                        title="Delete">
                                        <a class="remove-item-btn" data-bs-toggle="modal"
                                           href="#deleteRecordModal">
                                            <i class="ri-delete-bin-fill align-bottom text-muted"></i>
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>`


fetch('/api/companies.json')
    .then((response) => response.json())
    .then((companies) => {
        console.log(companies)
        // companies.map((company) => tableBody.append(codeBlock))
    })