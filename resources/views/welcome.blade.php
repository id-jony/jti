<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./assets/css/reset.css">
        <link rel="stylesheet" href="./assets/css/main.css">
		<link rel="stylesheet" href="./assets/css/styles.css?v=4">
        <script src="./assets/js/alpinejs.min.js" defer></script>
        <title>Ploom</title>
    </head>

	<body>
		<div class="bg_abstract_element">
			<div class="container">
				<nav>
					<a href="/"><img src="./assets/images/logo.svg" alt="Logo" class="logo"></a>
					<!-- <ul>
						<li><a href="#">Главная</a></li>
						<li><a href="#"><b>QR</b>-код</a></li>
					</ul> -->
					<div class="nav-right">
						@if(app()->getLocale() === 'ru')
                            <a href="{{ route('index', ['lang' => 'kk']) }}">kk</a>
                        @else
                            <a href="{{ route('index', ['lang' => 'ru']) }}">ru</a>
                        @endif
					</div>
				</nav>

				<div class="main-block" x-data="data">
					<img src="./assets/images/tagline.svg" alt="tagline" :class="step == 2 ? 'tagline-mini' : 'tagline'">

					<template x-if="step == 1">
						<div class="content-1">
							{{ __('moonshine::ui.web.date') }} <b>20:00</b><br>
							<b>GRAND BALLROOM ROYAL TULIP</b><br>
							{{ __('moonshine::ui.web.place') }}
							<button type="button" class="reg-btn" @click="step = 2">{{ __('moonshine::ui.web.registration') }}</button>

							<div class="headliners">
								<div>
									ХЭДЛАЙНЕР: <br><b>JAH KHALIB</b>
								</div>
								<div class="nowrap">
									{{ __('moonshine::ui.web.format') }} <br><b>{{ __('moonshine::ui.web.format_val') }}</b>
								</div>
								<div>
									ДРЕСС-КОД: <br><b>КОКТЕЙЛЬ</b>
								</div>
							</div>
						</div>
					</template>

					<template x-if="step == 2">
						<div class="content-2">
							<div class="form-block">
								<div class="form-control">
									<select class="form-input" x-model="department">
										<option value="0" selected></option>
										<template x-for="item in departmentList">
											<option :value="item.id" x-text="item.name"></option>
										</template>
									</select>
									<label>{{ __('moonshine::ui.web.choose_department') }}</label>
								</div>
								<div class="form-control">
									<select class="form-input" x-model="employee">
										<option value="0" selected></option>
										<template x-for="item in employeeList">
											<option :value="item.id" x-text="item.name"></option>
										</template>
									</select>
									<label>{{ __('moonshine::ui.web.choose') }}</label>
								</div>
								<template x-if="employeeItem !== null">
									<div class="form-control">
										<input type="email" class="form-input" x-model="employeeEmail" :disabled="!!employeeItem.email">
										<label x-text="!!employeeItem.email ? '{{ __('moonshine::ui.web.email') }}' : '{{ __('moonshine::ui.web.fill_email') }}'"></label>
									</div>
								</template>
								<template x-if="showError">
									<div class="error">
										{{ __('moonshine::ui.web.fill_data') }}
									</div>
								</template>
							</div>
							<button type="button" class="submit-btn" @click="registrate()" :disabled="loading">{{ __('moonshine::ui.web.registrate') }} <span class="spinner"></span></button>
						</div>
					</template>

					<template x-if="step == 3">
						<div class="content-3">
							<h3>{!! __('moonshine::ui.web.success_registration') !!}</h3>
							<p class="subtext">{!! __('moonshine::ui.web.subtext') !!}</p>
                            <p class="can"> {{ __('moonshine::ui.web.can') }}</p>
                            <a class="link" x-bind:href="download">{{ __('moonshine::ui.web.download') }}</a>
							<p class="remark">{{ __('moonshine::ui.web.remark') }}</p>
						</div>
					</template>

				</div>
			</div>
		</div>
	</body>
	<script>
		document.addEventListener('alpine:init', () => {
			Alpine.data('data', () => ({
				init() {
					this.getDepartments();
					this.$watch('department', v => {
						this.employeeList = [];
						this.showError = false;
						this.employee = null;
						this.employeeItem = null;
                        this.download = null;
						if(!!+v) {
							this.getEmployees();
						}
					});
					this.$watch('employee', v => {
						this.showError = false;
						if(!!+v) {
							this.employeeItem = this.employeeList.find(item => item.id == this.employee);
							// this.employeeItem.email = '';
							this.employeeEmail = this.employeeItem.email;
						} else {
							this.employeeItem = null;
						}
					});
					this.$watch('employeeEmail', v => {
						this.showError = false;
					});
				},
				step: 1,
				loading: false,
				showError: false,
				department: null,
				departmentList: [],
				employee: null,
				employeeItem: null,
				employeeEmail: null,
				employeeList: [],
				getDepartments: async function () {
					try {
						this.loading = true;
						const response = await fetch('/api/departments');
						if (response.ok) {
							const data = await response.json();
							this.departmentList = data.data;
						} else {
							console.error('Failed to fetch data');
						}
					} catch (error) {
						console.error('An error occurred:', error);
					} finally {
						this.loading = false;
					}
				},
				getEmployees: async function () {
					try {
						this.loading = true;
						const response = await fetch(`/api/departments/${this.department}/employees`);
						if (response.ok) {
							const data = await response.json();
							this.employeeList = data.data;
						} else {
							console.error('Failed to fetch data');
						}
					} catch (error) {
						console.error('An error occurred:', error);
					} finally {
						this.loading = false;
					}
				},
				registrate: async function () {
					if(!+this.department || !+this.employee || (this.employeeItem?.has_email === false && (!this.employeeEmail || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.employeeEmail)))) {
						this.showError = true;
					} else {
						try {
						this.loading = true;

						const postData = {
							employee_id: this.employee,
							email: this.employeeItem.email ? null : this.employeeEmail,
                            lang: '{{ str_replace('_', '-', app()->getLocale()) }}'
						};

						const requestOptions = {
							method: 'POST',
							headers: {
								'Content-Type': 'application/json',
								'Accept': 'application/json',
							},
							body: JSON.stringify(postData),
						};

						const response = await fetch(`/api/registration`, requestOptions);
							if (response.ok) {
								const data = await response.json();
								this.step = 3;
                                this.download = data.route;
                                window.open(data.route, '_blank');
							} else {
								alert('Failed to fetch data');
							}
						} catch (error) {
							console.error('An error occurred:', error);
						} finally {
							this.loading = false;
						}
					}
				}
			}));
		});
	</script>

	</html>
